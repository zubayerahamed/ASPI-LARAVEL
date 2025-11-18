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
        $id = $request->query('id', 'RESET'); // Returns null if not present
        $frommenu = $request->query('frommenu', 'N'); // Returns null if not present

        if ($request->ajax()) {
            if ($frommenu == 'Y') {
                return response()->json([
                    'page' => view('pages.DASH.DASH', [])->render(),
                    'content_header_title' => 'Dashboard',
                    'subtitle' => 'Dashboard',
                ]);
            }
        }

        return view('index', [
            'page' => 'pages.DASH.DASH',
            'content_header_title' => 'Dashboard',
            'subtitle' => 'Dashboard',
        ]);
    }
}
