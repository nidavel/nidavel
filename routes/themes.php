<?php

use App\Http\Controllers\ThemeController;
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

Route::get('/', [ThemeController::class, 'index'])
    ->middleware(BlastaDashboard::class);
Route::get('/fetch', [ThemeController::class, 'fetch'])
    ->middleware(BlastaDashboard::class);

Route::post('/activate/{theme}', [ThemeController::class, 'activate']);
Route::get('/fetch-all', [ThemeController::class, 'fetchAll']);
Route::get('/download', [ThemeController::class, 'download']);
