<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/{category}', [CategoryController::class, 'list']);
Route::get('/{category}/{post}', [CategoryController::class, 'show']);
