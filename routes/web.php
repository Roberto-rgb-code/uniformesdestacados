<?php

use App\Http\Controllers\UniformeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UniformeController::class, 'create'])->name('uniformes.create');
Route::post('/uniformes', [UniformeController::class, 'store'])->name('uniformes.store');
Route::get('/uniformes', [UniformeController::class, 'index'])->name('uniformes.index');
Route::get('/uniformes/{id}/edit', [UniformeController::class, 'edit'])->name('uniformes.edit');
Route::put('/uniformes/{id}', [UniformeController::class, 'update'])->name('uniformes.update');
Route::delete('/uniformes/{id}', [UniformeController::class, 'destroy'])->name('uniformes.destroy');
Route::delete('/fotos/{fotoId}', [UniformeController::class, 'destroyPhoto'])->name('fotos.destroy');