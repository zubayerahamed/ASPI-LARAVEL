<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Services\ZayaanSessionManager;
use Illuminate\Http\Request;

class ProfileSelectionController extends ZayaanController
{
    public function index()
    {
        $currentBusinessId = getBusinessId();

        // Get Auth User's businesses
        $loggedInUser = User::with([
            'businesses' => function ($query) use ($currentBusinessId) {
                $query->where('business_id', $currentBusinessId)->wherePivot('is_active', true);
            },
            'profiles' => function ($query) use ($currentBusinessId) {
                $query->wherePivot('business_id', $currentBusinessId);
            }
        ])->find(getLoggedInUserDetails()['id']); // Refresh user data
        
        $profiles = $loggedInUser->profiles;

        // Check if user has selected profile
        if (getSelectedProfile()) {
            // Filter and remove the selected profile from the list
            $profiles = $profiles->filter(function ($profile){
                return $profile->id !== getProfileId();
            });
        }

        return view('index', [
            'page' => 'pages.profile-selection',
            'content_header_title' => getSelectedProfile() == null ? 'Select Profile' : 'Switch Profile',
            'subtitle' => 'Profile Selection',
            'profiles' => $profiles
        ]);
    }

    public function selectProfile(Request $request, $id)
    {
        // Check profile existence
        $profile = Profile::with('users')->where('business_id', getBusinessId())->find($id);

        if (!$profile) {
            return redirect()->route('home')->withErrors(['Profile not found.']);
        }

        // Check user is assigned to the profile
        $profileUserIds = $profile->users->pluck('id')->toArray();
        if (!in_array(getLoggedInUserDetails()['id'], $profileUserIds)) {
            return redirect()->route('home')->withErrors(['You are not assigned to the selected profile.']);
        }

        // Add the profile data to the session with logged in user details
        // Remove previous selected profile if exist
        $loggedInUser = getLoggedInUserDetails();
        $loggedInUser['selected_profile'] = [
            'id' => $profile->id,
            'name' => $profile->name,
            'slug' => $profile->slug,
        ];
        ZayaanSessionManager::update('user_info', $loggedInUser);

        return redirect()->route('home')->with('success', 'Profile selected successfully.');
    }
}
