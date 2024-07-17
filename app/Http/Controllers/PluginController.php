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

        addDashboardNotice('plugin_activate', [
            'title' => 'Plugin activate',
            'message' => "Plugin '$plugin' activated successfully."
        ]);

        runFunctionsOnPluginEvent('plugin-activate', $plugin);

        return redirect()->back();
    }

    public function deactivate(Request $request)
    {
        $plugin = $this->getPluginNameFromUrl($request->url());
        deactivatePlugin($plugin);

        addDashboardNotice('plugin_deactivate', [
            'title' => 'Plugin deactivate',
            'message' => "Plugin '$plugin' deactivated successfully."
        ]);

        runFunctionsOnPluginEvent('plugin-deactivate', $plugin);

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $plugin = $this->getPluginNameFromUrl($request->url());
        deletePlugin($plugin);

        addDashboardNotice('plugin_delete', [
            'title' => 'Plugin delete',
            'message' => "Plugin '$plugin' deleted successfully."
        ]);

        runFunctionsOnPluginEvent('plugin-delete', $plugin);

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
