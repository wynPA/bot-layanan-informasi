<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Jalur khusus untuk menerima data dari Bot WA
Route::post('/surat-masuk/bot', [DashboardController::class, 'storeFromBot']);