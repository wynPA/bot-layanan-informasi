<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratKeluarController;

Route::post('/update-status/{id}', [DashboardController::class, 'updateStatus']);
Route::post('/archive-surat/{id}', [DashboardController::class, 'archive']);
Route::post('/update-checklist/{id}', [DashboardController::class, 'updateChecklist']);

// Laman Dashboard Surat Keluar
Route::get('/surat-keluar', [SuratKeluarController::class, 'index'])->name('surat-keluar.index');

// Endpoint untuk Bot (Nanti diakses via Webhook)
Route::post('/api/bot/request-nomor', [SuratKeluarController::class, 'generateFromBot']);

// Laman Pengisian Kolektif
Route::get('/isi-detail/{token}', [SuratKeluarController::class, 'formKolektif'])->name('isi-detail');

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
