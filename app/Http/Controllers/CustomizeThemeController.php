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

    public function saveCustomizedStyle(Request $request)
    {
        $name = $request->name;
        $data = $request->data;
        $file = base_path("app/Blasta/CustomizedStyles/$name");

        if (!file_exists(base_path("app/Blasta/CustomizedStyles"))) {
            mkdir(base_path("app/Blasta/CustomizedStyles"));
        }

        $fp = fopen($file, 'w');
        fwrite($fp, " $data");
        fclose($fp);

        return response()->json(['data'=>'received']);
    }
}
