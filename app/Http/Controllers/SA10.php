<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SA10 extends ZayaanController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $html = view('pages.SA10.SA10')->render();

            return response()->json([
                'page' => $html,
                'content_header_title' => 'Business',
                'subtitle' => 'Business',
            ]);
        }

        return view('index', [
            'page' => 'pages.SA10.SA10',
            'content_header_title' => 'Business',
            'subtitle' => 'Business',
        ]);
    }
}
