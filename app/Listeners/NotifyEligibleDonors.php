<?php

namespace App\Listeners;

use App\Events\BloodRequestCreated;
use App\Notifications\NewBloodRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class NotifyEligibleDonors
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BloodRequestCreated $event): void
    {
        $bloodRequest = $event->bloodRequest;

        $eligibleDonors = User::query()
            ->with('donorProfile')
            ->where('is_blocked', false)
            ->where('blood_group', $bloodRequest->blood_group)
            ->where('district_id', $bloodRequest->district_id)
            ->where('id', '!=', $bloodRequest->requester_user_id)
            ->when(
                $bloodRequest->city_corporation_id,
                fn($q) => $q->where('city_corporation_id', $bloodRequest->city_corporation_id)
            )
            ->when(
                $bloodRequest->city_area_id,
                fn($q) => $q->where('city_area_id', $bloodRequest->city_area_id)

            )
            ->when(
                $bloodRequest->upazilla_id,
                fn($q) => $q->where('upazilla_id', $bloodRequest->upazilla_id)
            )
            ->whereHas('donorProfile', function ($q) {
                $q->where('is_available', true)
                    ->where(function ($sub) {
                        $sub->whereNull('next_eligible_date')
                            ->orWhereDate('next_eligible_date', '<=', today());
                    });
            })
            ->get();

        foreach ($eligibleDonors as $donor) {
            $donor->notify(new NewBloodRequestNotification($bloodRequest));
        }




    }
}
