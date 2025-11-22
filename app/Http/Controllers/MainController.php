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

        // Check if user has selected business
        if (getSelectedBusiness() == null) {
            return redirect()->route('business-selection');
        }

        if(!($loggedInUser->is_system_admin || $loggedInUser->is_business_admin)){
            if(getSelectedProfile() == null) {
                return redirect()->route('profile-selection');
            }
        }

        return view('index', [
            'page' => 'pages.navigation-selection',
            'content_header_title' => 'Select Navigation',
            'subtitle' => 'Navigation Selection',
        ]);
    }
}
