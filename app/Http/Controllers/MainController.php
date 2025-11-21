<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use App\Services\ZayaanSessionManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class MainController extends ZayaanController
{
    /**
     * Show the application main page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Config::get('adminlte.menu'));
        // dd(getLoggedInUserDetails());
        // dd(getSelectedBusiness());

        // If already has selected business, redirect to dashboard
        // if (getSelectedBusiness()) {
        //     return view('index', [
        //         'page' => 'pages.DASH.DASH',
        //         'content_header_title' => 'Dashboard',
        //         'subtitle' => 'Dashboard',
        //     ]);
        // }

        // Get Auth User's businesses
        $loggedInUser = User::find(getLoggedInUserDetails()['id']); // Refresh user data
        $businesses = $loggedInUser->businesses()->with(['businessCategory'])->orderBy('name', 'asc')->get();

        // Check if user has selected business
        if (getSelectedBusiness()) {
            // Filter and remove the selected business from the list
            $selectedBusinessId = getSelectedBusiness()['id'];
            $businesses = $businesses->filter(function ($business) use ($selectedBusinessId) {
                return $business->id !== $selectedBusinessId;
            });
        }

        return view('index', [
            'page' => 'pages.business-selection',
            'content_header_title' => getSelectedBusiness() == null ? 'Select Business' : 'Switch Business',
            'subtitle' => 'Business Selection',
            'businesses' => $businesses
        ]);
    }
}
