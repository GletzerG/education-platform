<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verify.mentor'])
    ->name('dashboard');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'role:guru'])
    ->name('admin.dashboard');

Route::get('/mentor/waiting', function () {
    return view('mentor.waiting');
})->name('mentor.waiting')->middleware('auth');

// Class Routes
Route::get('/navbar/classes', [ClassController::class, 'index'])
    ->name('navbar.classes')
    ->middleware('auth');

Route::get('/navbar/mentor', function () {
    return view('navbar.mentor');
})->name('navbar.mentor');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Profile Routes - SEMUA DENGAN MIDDLEWARE AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard profil (user lihat profil)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    
    // Form edit profil (Breeze)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // Update profil (Breeze default)
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Hapus akun
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Update profil custom (termasuk avatar)
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update.custom');
    
    // Upload avatar saja (AJAX) - HANYA INI YANG DIPAKAI
    Route::post('/profile/upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.upload-avatar');
});

/*
|--------------------------------------------------------------------------
| Class Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');
});

/*
|--------------------------------------------------------------------------
| Mentor Routes (Role: mentor)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mentor'])->group(function () {
    Route::controller(ClassController::class)->group(function () {
        Route::get('/my-classes', 'my')->name('classes.my');
        Route::get('/create', 'create')->name('classes.create');
        Route::post('/classes', 'store')->name('classes.store');
        Route::get('/classes/{id}/edit', 'edit')->name('classes.edit');
        Route::put('/classes/{id}', 'update')->name('classes.update');
        Route::delete('/classes/{id}', 'destroy')->name('classes.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Role: guru)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/mentor/pending', [MentorController::class, 'pending'])->name('mentor.pending');
    Route::post('/mentor/approve/{user}', [MentorController::class, 'approve'])->name('mentor.approve');
    Route::post('/mentor/reject/{user}', [MentorController::class, 'reject'])->name('mentor.reject');
});

// Mentor profile
Route::get('/mentor/{id}', function ($id) {
    return "Profile mentor ID: " . $id;
})->name('mentor.profile');

// Auth routes
require __DIR__ . '/auth.php';