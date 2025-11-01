<?php

namespace App\Http\Controllers;

use App\Traits\ResponseHelper;
use Illuminate\Http\Request;

class ZayaanController extends Controller
{
    use ResponseHelper;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
