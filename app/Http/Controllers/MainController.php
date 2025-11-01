<?php

namespace App\Http\Controllers;

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
        return view('index', [
            'page' => 'pages.examples',
            'content_header_title' => 'Dynamic Elements & Data Tables',
            'subtitle' => 'Dynamic Elements & Data Tables',
        ]);
    }
}
