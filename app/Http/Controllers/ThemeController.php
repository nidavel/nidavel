<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.themes.index');
    }

    /**
     * Activates a selected theme
     */
    public function activate(Request $request)
    {
        $urlExplode = explode('/', $request->url());
        $theme = $urlExplode[count($urlExplode) - 1];
        activateTheme($theme);

        return redirect()->back();
    }

    /**
     * Fetch all themes from online repository
     */
    public function fetch(Request $request)
    {
        $result = fetchFreeThemes();
    
        return view('dashboard.themes.fetch', [
            'themes' => json_decode($result)->data
        ]);
    }

    /**
     * Downloads a theme to the themes directory
     */
    public function download(Request $request)
    {
        $themeName     = $request->query('theme_name');
        $themeUrl      = $request->query('theme_url');
        $themeVersion  = ltrim($request->query('theme_version'), strtolower('v'));
        $downloadUrl    = "$theme_url/archive/refs/tags/$themeVersion.zip";
        // dd($downloadUrl);
        if (downloadTheme($downloadUrl) === true) {
            if (extractTheme(theme_path("/$themeName-$themeVersion.zip"))) {
                rename(theme_path("/$themeName-$themeVersion"), theme_path("/$themeName"));
                if (deleteZipped(theme_path("/$themeName-$themeVersion.zip"))) {
                    dd(true);
                } else {
                    dd(false);
                }
            }
        }
    }

    /**
     * Searches for a theme in the themes repository
     */
    public function search(Request $request)
    {
        $result = searchFreeThemes($request->q);
        // $result = json_decode($result)->data;
        // dd(json_decode($result)->data);

        return redirect('dashboard?route=themes/search-page')
            ->with([
                'themes' => $result
            ]);

        // return view('dashboard.themes.search-page', [
        //     'themes' => $result
        // ]);

        // return redirect()
        //     ->route('themes.search', ['themes'=>json_encode($result)]);
    }

    /**
     * Searches for a theme in the themes repository
     */
    public function searchPage()
    {
        // $result = searchFreeThemes($request->q);

        return view('dashboard.themes.search-page');
    }
}
