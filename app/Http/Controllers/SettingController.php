<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.settings.index');
    }

    public function set(Request $request)
    {
        $key = $request->input('key');
        settings('d', $key);

        foreach ($request->all() as $setting => $value) {
            if ($setting === 'key') {
                continue;
            }
            settings('w', "$key.$setting", $value);
        }

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        // 
    }
}
