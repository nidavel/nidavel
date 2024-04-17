<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PageController;
use App\Models\Page;
// use App\Settings;

// class HomeController extends Controller
// {
//     public function home()
//     {
//         $settings = BlastaSettings::getInstance();
//         $homepage = $settings->get("general", "homepage");
    
//         if ($homepage === "index") {
//             return view('front.posts');
//         }
//         else if (is_int($homepage)) {
//             $page = Page::find($homepage);
//             return view('front.page', [
//                 'page' => $page
//             ]);
//         }
//         else {
//             return view('front.pages.' . $homepage);
//         }
//     }
// }
