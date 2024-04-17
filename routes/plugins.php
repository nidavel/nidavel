<?php

use App\Http\Controllers\PluginController;
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

Route::get('/', [PluginController::class, 'index'])
    ->middleware(BlastaDashboard::class);

Route::post('/activate/{plugin}', [PluginController::class, 'activate']);
Route::post('/deactivate/{plugin}', [PluginController::class, 'deactivate']);
Route::post('/delete/{plugin}', [PluginController::class, 'delete']);
Route::post('/download/{plugin}', [PluginController::class, 'download']);
Route::get('/fetch', [PluginController::class, 'download']);
