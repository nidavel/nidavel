<?php

use Illuminate\Support\Facades\Route;

Route::get('/remove/{notice}', function ($notice) {
    removeDashboardNotice($notice);
    return response()->json([
        'msg' => 'success'
    ]);
});

Route::get('/get-dashboard-alerts', function () {
    if (!empty($_COOKIE['dashboard-alerts'])) {
        return json_encode($_COOKIE['dashboard-alerts']);
    }

    return null;
});
