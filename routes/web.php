<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [QuoteController::class, 'index'])->middleware('auth');
    Route::get('/quotes', [QuoteController::class, 'index'])->middleware('auth');
    Route::post('/quotes/refresh', [QuoteController::class, 'refresh'])->middleware('auth');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';