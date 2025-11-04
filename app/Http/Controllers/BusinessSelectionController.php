<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;

class BusinessSelectionController extends ZayaanController
{
    // Logic to handle business selection based on the provided ID
    // This could involve setting a session variable, redirecting, etc.
    public function selectBusiness(Request $request, $id)
    {
        // Check business existence
        $business = Business::find($id);
        if (!$business) {
            return redirect()->route('home')->withErrors(['Business not found.']);
        }

        // Check user is assigned to the business 
        $loggedInUser = $request->session()->get('user_info');

        $user = User::with('businesses')->find($loggedInUser['id']);
        $userBusinessIds = $user->businesses->pluck('id')->toArray();

        if (!in_array($business->id, $userBusinessIds)) {
            return redirect()->route('home')->withErrors(['You are not assigned to the selected business.']);
        }

        // Add the business data to the session
        $request->session()->put('selected_business', $business);

        // if user is system admin, then go to dashboard
        if ($user->is_system_admin) {
            return redirect()->route('DASH');
        }

        // If user is not system admin, then go to profile selection page, if user has single profile, then set profile to session and go to dashboard
        return redirect()->route('DASH');
    }
}
