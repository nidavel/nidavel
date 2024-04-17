<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppearanceController extends Controller
{
    public function index()
    {
        return view('dashboard.appearance.index');
    }
}
