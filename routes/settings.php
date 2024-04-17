<?php

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\BlastaDashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [SettingController::class, 'index'])
    ->middleware(BlastaDashboard::class);

Route::post('/set', [SettingController::class, 'set']);
