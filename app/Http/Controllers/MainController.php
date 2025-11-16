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


        // Get Auth User's businesses
        $user = Auth::user();
        $loggedInUser = User::find($user->id); // Refresh user data
        $businesses = $loggedInUser->businesses()->with(['businessCategory'])->orderBy('name', 'asc')->get();

        return view('index', [
            'page' => 'pages.business-selection',
            'content_header_title' => 'Select Your Business',
            'subtitle' => 'Business Selection',
            'businesses' => $businesses
        ]);
    }
}
