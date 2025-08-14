<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NavbarMentorController;


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
// Di routes/web.php
    

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])
    ->name('user.profile')
    ->middleware('auth'); // Kalau perlu login

Route::middleware('auth')->group(function () {
    // Dashboard profil (user lihat profil)
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::get('/user/{id}', [ProfileController::class, 'show'])->name('user.show');

    // Form edit profil (Breeze)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update profil (Breeze default)
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Hapus akun
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', function () {
            return view('edit'); // Pastikan edit.blade.php ada di resources/views
        })->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });


    // Dummy routes for quick actions (replace with actual functionality)
    Route::get('/projects/create', function () {
        return redirect()->route('profile.dashboard')->with('info', 'Fitur create project akan segera hadir!');
    })->name('projects.create');

    Route::get('/reports', function () {
        return redirect()->route('profile.dashboard')->with('info', 'Fitur reports akan segera hadir!');
    })->name('reports.index');

    /*
    |--------------------------------------------------------------------------
    | Class Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
        Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');
        Route::get('/classes/{id}/learn', [ClassController::class, 'learn'])->name('classes.learn');
        Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
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

        Route::controller(MaterialController::class)->group(function () {
            Route::get('/materials/create/{class}', 'create')->name('materials.create');
            Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
            Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
            Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

            Route::post('/materials', 'store')->name('materials.store');
            // Tambahkan route material lainnya jika perlu
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


    // Halaman dashboard profile
    Route::get('/profile', [ProfileController::class, 'index'])
        ->middleware('auth')
        ->name('profile.index');

    // Form edit profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->middleware('auth')
        ->name('profile.edit');

    // Update profile
    Route::put('/profile', [ProfileController::class, 'update'])
        ->middleware('auth')
        ->name('profile.update');

    // Update password
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->middleware('auth')
        ->name('password.update');

    // Hapus akun
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('auth')
        ->name('profile.destroy');
});