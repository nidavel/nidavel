<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class InstallationController extends Controller
{
    public function installation(Request $request)
    {
        return view('installation.index');
    }

    public function install(Request $request)
    {
        // Set the app name
        $app_name = trim($request->app_name);
        $app_name = strlen($app_name) > 0 ? $app_name : null;

        if (is_null($app_name)) {
            return redirect()->back()->with([
                'message' => 'Application name field can not be empty.'
            ]);
        }

        settings('w', 'general.name', $app_name);

        // Copies the .env.example content into the .env file
        // 

        // Create the database
        $fp = fopen(database_path('database.sqlite'), 'w');
        fclose($fp);

        // Create the /public/my_exports dir and inner dirs
        rrmdir(public_path('/my_exports'));
        mkUriDir(public_path('/my_exports'));
        mkUriDir(public_path('/my_exports/assets'));
        mkUriDir(public_path('/my_exports/pages'));
        mkUriDir(public_path('/my_exports/posts'));
        mkUriDir(public_path('/my_exports/uploads'));
        mkUriDir(public_path('/my_exports/uploads/images'));
        mkUriDir(public_path('/my_exports/uploads/audios'));
        mkUriDir(public_path('/my_exports/uploads/videos'));

        // SoftLink the /public/my_exports/uploads to /public/uploads
        if (file_exists(public_path('uploads'))) {
            if (is_dir(public_path('uploads'))) {
                rrmdir(public_path('uploads'));
            } else {
                unlink(public_path('uploads'));
            }
        }
        Artisan::call('uploads:link');

        // Export current theme assets
        exportAssets();

        // SoftLink the /public/my_exports/assets to /public/assets
        if (file_exists(public_path('assets'))) {
            if (is_dir(public_path('assets'))) {
                rrmdir(public_path('assets'));
            } else {
                unlink(public_path('assets'));
            }
        }
        $myExports_assets   = str_replace('\\', '/', (public_path('my_exports/assets')));
        $publicPath_assets  = str_replace('\\', '/', (public_path('assets')));
        Artisan::call("nidavel:link \"$myExports_assets\" \"$publicPath_assets\"");

        // Migrate the tables
        Artisan::call('migrate:fresh');

        // Cache config
        // Artisan::call('config:cache');

        // Remove install flag
        if (file_exists(base_path('/install'))) {
            unlink(base_path('/install'));
        }

        // Generate unique key
        // Artisan::call('key:generate');

        // Redirect to the register page
        return redirect()->to('http://localhost:8000/register');
    }
}
