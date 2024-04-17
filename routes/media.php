<?php

use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\BlastaDashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register post routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MediaController::class, 'index']);

Route::get('/all', [MediaController::class, 'all'])
    ->middleware(BlastaDashboard::class);
Route::get('/all/{filter}', [MediaController::class, 'all'])
    ->middleware(BlastaDashboard::class);

Route::post('/add', [MediaController::class, 'add']);
Route::delete('/delete', [MediaController::class, 'delete']);

// Route::post('/post/{post}', [ExportController::class, 'exportPost']);
// Route::post('/page/{post}', [ExportController::class, 'exportPage']);
// Route::get('/homepage', [ExportController::class, 'exportHomepage']);
// Route::get('/assets', [ExportController::class, 'exportAssets']);


// Route::get('/posts', [ExportController::class, 'exportPosts']);
