<?php

namespace App\Notifications;

use App\Models\BloodRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBloodRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public BloodRequest $bloodRequest)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'blood_request_id' => $this->bloodRequest->id,
            'patient_name' => $this->bloodRequest->patient_name,
            'blood_group' => $this->bloodRequest->blood_group,
            'needed_date' => $this->bloodRequest->needed_date,
            'requester_name' => $this->bloodRequest->requester_name,
            'requester_phone' => $this->bloodRequest->requester_phone,
            'district_id' => $this->bloodRequest->district_id,
            'city_corporation_id' => $this->bloodRequest->city_corporation_id,
            'city_area_id' => $this->bloodRequest->city_area_id,
            'message' => 'A new blood request matches your profile.',
        ];
    }
}
