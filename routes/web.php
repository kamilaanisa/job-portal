<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ----------------------------------------------------------------
// --- RUTE MODUL "EXPORT/IMPORT" ---
// ----------------------------------------------------------------

// --- Rute Spesifik (HARUS DI ATAS) ---
Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
    ->name('apply.store')
    ->middleware('auth');

Route::get('/jobs/{job}/applicants', [ApplicationController::class, 'index'])
    ->name('applications.index')
    ->middleware('auth', 'isAdmin');

// [LATIHAN 6] Rute Download CV
Route::get('/applications/{application}/download', [ApplicationController::class, 'downloadCV'])
    ->name('applications.download')
    ->middleware('auth', 'isAdmin');

// [LATIHAN 7] Rute Export (spesifik per lowongan)
Route::get('/jobs/{jobId}/applications/export', [ApplicationController::class, 'export'])
    ->name('applications.export')
    ->middleware('auth', 'isAdmin');

// [LATIHAN 8] Rute Download Template Import
Route::get('/jobs/import-template', [JobController::class, 'downloadTemplate'])
    ->name('jobs.template')
    ->middleware('auth', 'isAdmin');

//Rute Import
Route::post('/jobs/import', [JobController::class, 'import'])
    ->name('jobs.import')
    ->middleware('auth', 'isAdmin');


// --- Rute Umum 'jobs' (Resource) (HARUS DI BAWAH) ---
// Mengarah ke JobController
Route::resource('jobs', JobController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

Route::resource('jobs', JobController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);


// --- Rute Umum 'applications' (Resource) ---
// Digunakan untuk tombol "Terima/Tolak" (update)
Route::resource('applications', ApplicationController::class)
    ->middleware(['auth', 'isAdmin']) // Hanya admin yang bisa update
    ->only(['update', 'destroy']); // Tambahkan destroy jika perlu


require __DIR__.'/auth.php';