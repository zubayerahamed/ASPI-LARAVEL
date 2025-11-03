<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class MainController extends ZayaanController
{
    /**
     * Show the application main page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $businesses = Business::with(['businessCategory'])->orderBy('name', 'asc')->get();

        return view('index', [
            'page' => 'pages.business-selection',
            'content_header_title' => 'Select Your Business',
            'subtitle' => 'Business Selection',
            'businesses' => $businesses
        ]);
    }
}
