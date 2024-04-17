<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PluginController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.plugins.index');
    }

    public function activate(Request $request)
    {
        $plugin = $this->getPluginNameFromUrl($request->url());
        activatePlugin($plugin);

        return redirect()->back();
    }

    public function deactivate(Request $request)
    {
        $plugin = $this->getPluginNameFromUrl($request->url());
        deactivatePlugin($plugin);

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $plugin = $this->getPluginNameFromUrl($request->url());
        deletePlugin($plugin);

        return redirect()->back();
    }

    public function download(Request $request)
    {
        // 
    }

    public function fetch(Request $request)
    {
        // 
    }
    
    private function getPluginNameFromUrl(string $url): string
    {
        $pluginUrlChomped = explode('/', $url);
        $plugin = $pluginUrlChomped[count($pluginUrlChomped) - 1];
        return rawurldecode($plugin);
    }
}
