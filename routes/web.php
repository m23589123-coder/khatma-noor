<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KhatmaController;

Route::get('/', [KhatmaController::class, 'index'])->name('khatma.index');
Route::post('/reserve/{id}', [KhatmaController::class, 'reserve'])->name('khatma.reserve');
Route::get('/read/{id}', [KhatmaController::class, 'read'])->name('khatma.read');
Route::post('/complete/{id}', [KhatmaController::class, 'complete'])->name('khatma.complete');

// مسار حائط الدعاء
Route::post('/doaa', [KhatmaController::class, 'storeDoaa'])->name('khatma.doaa');
