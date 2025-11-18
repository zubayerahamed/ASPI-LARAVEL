<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use App\Services\ZayaanSessionManager;
use Illuminate\Http\Request;

class BusinessSelectionController extends ZayaanController
{
    // Logic to handle business selection based on the provided ID
    // This could involve setting a session variable, redirecting, etc.
    public function selectBusiness(Request $request, $id)
    {
        // Check business existence
        $business = Business::with(['businessCategory'])->find($id);
        if (!$business) {
            return redirect()->route('home')->withErrors(['Business not found.']);
        }

        // Check user is assigned to the business 
        $loggedInUser = getLoggedInUserDetails();

        $user = User::with('businesses')->find($loggedInUser['id']);
        $userBusinessIds = $user->businesses->pluck('id')->toArray();

        if (!in_array($business->id, $userBusinessIds)) {
            return redirect()->route('home')->withErrors(['You are not assigned to the selected business.']);
        }

        // Add the business data to the session with logged in user details
        // Remove previous selected business if exist
        $loggedInUser['selected_business'] = [
            'id' => $business->id,
            'name' => $business->name,
            'country' => $business->country,
            'currency' => $business->currency,
            'email' => $business->email,
            'mobile' => $business->mobile,
            'is_inhouse' => $business->is_inhouse,
            'is_pickup' => $business->is_pickup,
            'is_delivery' => $business->is_delivery,
            'is_active' => $business->is_active,
            'is_allow_custom_menu' => $business->is_allow_custom_menu,
            'is_allow_custom_category' => $business->is_allow_custom_category,
            'is_allow_custom_attribute' => $business->is_allow_custom_attribute,
            'is_allow_custom_xcodes' => $business->is_allow_custom_xcodes,
            'business_category_code' => $business->businessCategory->xcode,
        ];
        ZayaanSessionManager::update('user_info', $loggedInUser);

        // if user is system admin, then go to dashboard
        if ($user->is_system_admin) {
            return redirect()->route('home');
        }

        // If user is not system admin, then go to profile selection page, if user has single profile, then set profile to session and go to dashboard
        return redirect()->route('home');
    }
}
