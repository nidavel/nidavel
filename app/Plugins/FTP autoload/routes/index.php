<?php

use Illuminate\Support\Facades\Route;
use Nidavel\FtpAutoLoad\Classes\FTPA;

Route::get('/ftpa/upload-site', function () {
    $ftpa = FTPA::getInstance();

    if ($ftpa !== null) {
        $ftpa::uploadSite();
    }
    
    return redirect()->back();
});
