<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\BlastaDashboardCheck;
use App\Http\Middleware\BlastaDashboard;
use App\Http\Middleware\CheckInstalled;

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

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', BlastaDashboardCheck::class, CheckInstalled::class])->name('dashboard');

Route::get('/home', [DashboardController::class, 'index'])
    ->middleware([BlastaDashboard::class, CheckInstalled::class]);
