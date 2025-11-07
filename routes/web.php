<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SendEmailController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register'); // ← showRegisterForm
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // ← showLoginForm
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/hello', function () {
    return "Halo, ini halaman percobaan route!";
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ========== SOAL 1: Route /profile untuk user login (BUKAN ADMIN) ==========
Route::middleware(['auth', 'isUser'])->group(function () {
   
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile.show');
    
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route logout khusus testing (alternatif pakai GET)
Route::get('/logout-test', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/')->with('message', 'Logout berhasil!');
})->middleware('auth')->name('logout.test');

Route::get('/jobs', [JobController::class, 'index']);

// ========== Route Admin ==========
Route::get('/admin', function () {
    return "
        <h1>Halo Admin!</h1>
        <a href='/admin/jobs'>Kelola Jobs</a> | 
        <a href='/dashboard'>Dashboard</a> | 
        <a href='/logout-test'>Logout</a>
    ";
})->middleware(['auth', 'isAdmin']);

// ========== SOAL 2: Route /admin/jobs untuk admin - pakai Blade ==========
Route::get('/admin/jobs', function () {
    $jobs = [
        ['position' => 'Web Developer', 'company' => 'PT Tech Indonesia', 'status' => 'Aktif'],
        ['position' => 'UI/UX Designer', 'company' => 'CV Kreatif Digital', 'status' => 'Aktif'],
        ['position' => 'Data Analyst', 'company' => 'PT Data Nusantara', 'status' => 'Ditutup'],
        ['position' => 'Backend Developer', 'company' => 'Startup Jaya', 'status' => 'Aktif'],
        ['position' => 'Mobile Developer', 'company' => 'PT App Solutions', 'status' => 'Aktif'],
        ['position' => 'DevOps Engineer', 'company' => 'Tech Corp', 'status' => 'Ditutup'],
    ];
    
    $totalJobs = count($jobs);
    $activeJobs = count(array_filter($jobs, fn($job) => $job['status'] == 'Aktif'));
    $closedJobs = $totalJobs - $activeJobs;
    
    return view('admin-jobs', compact('jobs', 'totalJobs', 'activeJobs', 'closedJobs'));
})->middleware(['auth', 'isAdmin']);

// ========== EMAIL ROUTES ==========
Route::get('/send-mail', [SendEmailController::class,'index'])->name('kirim-email');
Route::post('/post-email', [SendEmailController::class, 'store'])->name('post-email');

require __DIR__.'/auth.php';