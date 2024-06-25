<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PinPostController;

Route::post('/pin/{post}', [PinPostController::class, 'pin']);
Route::post('/unpin/{post}', [PinPostController::class, 'unpin']);
Route::post('/toggle/{post}', [PinPostController::class, 'toggle']);
