<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomizeThemeController extends Controller
{
    public function index()
    {
        return view('dashboard.customize-theme.index');
    }

    public function setThemeColor(Request $request)
    {
        setThemeColor($request->theme_color);

        return redirect()->back();
    }

    public function removeCustomizedStyleName(Request $request)
    {
        return removeCustomizedStyleName($request->name);
    }

    public function addCustomizedStyleName(Request $request)
    {
        return addCustomizedStyleName($request->name);
    }
}
