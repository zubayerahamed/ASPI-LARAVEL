<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends ZayaanController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $html = view('pages.dashboard')->render();
            return response()->json([
                'page' => $html,
                'content_header_title' => 'Dashboard',
                'subtitle' => 'Dashboard',
            ]);

            //return view('pages.dashboard')->render();
        }

        return view('index', [
            'page' => 'pages.dashboard',
            'content_header_title' => 'Dashboard',
            'subtitle' => 'Dashboard',
        ]);
    }
}
