<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.menu.index');
    }

    public function create(Request $request)
    {
        $x      = 0;
        $menu   = [];
        $title  = '';
        $url    = '';
        $target = null;
        $inputs = $request->input();

        clearMenu();

        foreach($inputs as $input) {
            switch ($x) {
                case 0:
                    $title = $input;
                break;
                case 1:
                    $url = $input;
                break;
                case 2:
                    $target = $input === 'none' ? null : $input;
                    addMenu($title, $url, $target);
                break;
                default:
                exit;
            }

            $x = ($x + 1) % 3;
        }

        return redirect()->back();
    }
}
