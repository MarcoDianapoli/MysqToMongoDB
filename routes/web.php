<?php

use App\Http\Controllers\AntojitoController;
use Illuminate\Support\Facades\Route;

Route::GET('/tables', [AntojitoController::class, 'index']);
Route::POST('/show-json', [AntojitoController::class, 'showJson']);
Route::POST('/insert-json', [AntojitoController::class, 'insertJson']);