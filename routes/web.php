<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

// Pages
Route::get('/', [AppController::class, 'index'])->name('app.index');

// Apis
Route::get('/switch/{id}', [AppController::class, 'switchCompleted'])->name('app.switch');
Route::post('/store', [AppController::class, 'store'])->name('app.store');
Route::post('/update', [AppController::class, 'update'])->name('app.update');
Route::get('/delete/{id}', [AppController::class, 'delete'])->name('app.delete');
