<?php

use Illuminate\Support\Facades\Route;

Route::get('/remove/{notice}', function ($notice) {
    removeDashboardNotice($notice);
    return response()->json([
        'msg' => 'success'
    ]);
});
