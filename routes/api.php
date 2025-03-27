<?php

use App\Http\Controllers\UniformeController;
use Illuminate\Support\Facades\Route;

Route::get('/uniformes-destacados', [UniformeController::class, 'apiIndex']);
Route::get('/uniformes-destacados/{id}', [UniformeController::class, 'apiShow']);