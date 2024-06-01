<?php

use Illuminate\Support\Facades\Route;

Route::get('/remove/{notice}', function ($notice) {
    removeNotice($notice);
    return response()->json([
        'msg' => 'success'
    ]);
});
