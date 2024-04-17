<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.widgets.index');
    }

    public function add(Request $request)
    {
        $body = json_decode($request->getContent(), true);
        // $activeWidgets = getActiveWidgets(true);

        foreach ($body as $widgetArea => $widgets) {
            foreach ($widgets as $widget) {
                $options = $widget['options'] ?? null;
                addToActiveWidgets($widgetArea, $widget['name'], $widget['body'], $options);
            }
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function set(Request $request)
    {
        $body = json_decode($request->getContent(), true);
        // $activeWidgets = getActiveWidgets(true);

        foreach ($body as $widgetArea => $widgets) {
            setActiveWidgets($widgetArea, $widgets);
        }

        

        return response()->json([
            'status' => 'success'
        ]);
    }
}
