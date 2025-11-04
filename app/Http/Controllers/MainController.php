<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends ZayaanController
{
    /**
     * Show the application main page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

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
