<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\Division;
use App\Models\District;
use App\Models\Area;
use App\Models\DonorProfile;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function completeForm(Request $request)
    {
        $user = $request->user();

        if($this->isProfileComplete($user)) {
            return redirect()->route('dashboard');
        }

        $divisions = Division::orderBy('name')->get(['id','name']);

        return view('profile.complete', compact('user', 'divisions'));


    }

    public function completeStore(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:11', 'unique:users,phone', $user->id],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,O+,O-,AB+,AB-'],

            'division_id' => ['required', 'exists:divisions,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'area_id' => ['required', 'exists:areas,id'],

            'address_line' => ['nullable', 'string', 'max:255'],
            'medical_history' => ['nullable', 'string'],
            'become_donor' => ['nullable', 'boolean'],
            'last_donate_date' => ['required', 'date'],

        ]);

        $user->phone = $validated['phone'];
        $user->blood_group = $validated['blood_group'];
        $user->division_id = $validated['division_id'];
        $user->district_id = $validated['district_id'];
        $user->area_id = $validated['area_id'];
        $user->address_line = $validated['address_line'] ?? null;
        $user->medical_history = $validated['medical_history'] ?? null;
        $user->save();

        $wantsDonor = (bool) ($validated['become_donor'] ?? false);

        if($wantsDonor) {
            $donor = DonorProfile::firstOrNew(['user_id' => $user->id]);
            $donor->is_available = true;
            $donor->last_donate_date = $validated['last_donate_date'] ?? null;
            
            if(!empty($donor->last_donate_date)) {
                $donor->next_eligible_date = Carbon::parse($donor->last_donate_date)->addDays(90)->toDateString();
            }

            $donor->save();
        }

        return redirect()->route('dashboard')->with('status', 'Profile Completed Successfully!');

    }

    public function districtsByDivision(Division $division)
    {
        return response()->json(
            District::where('division_id', $division->id)
                                ->orderBy('name')
                                ->get(['id', 'name'])
        );
    }

    public function areasByDistrict(District $district) 
    {
        return response()->json(
            Area::where('district_id',$district->id)
                        ->orderBy('name')
                        ->get(['id', 'name'])
        );
    }

    public function isProfileComplete($user)
    {
        return !empty($user->blood_group) && !empty($user->area_id);
    }
}
