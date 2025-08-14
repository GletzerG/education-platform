<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\NavbarMentorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route aplikasi didefinisikan di sini.
|--------------------------------------------------------------------------
*/

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});



// Mentor only routes


// Dashboard Siswa & Mentor

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verify.mentor'])
    ->name('dashboard');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'role:guru'])
    ->name('admin.dashboard');

Route::get('/mentor/waiting', function () {
    return view('mentor.waiting');
})->name('mentor.waiting')->middleware('auth');

Route::get('/navbar/classes', function () {
    return view('navbar.classes');
})->name('navbar.classes');

Route::get('/navbar/mentor', function () {
    return view('navbar.mentor');
})->name('navbar.mentor');

Route::get('/navbar/classes', [ClassController::class, 'index'])
    ->name('navbar.classes')
    ->middleware('auth');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login'); // langsung redirect ke route('login')
})->name('logout');


/*
|--------------------------------------------------------------------------
| Profile Routes (Hanya untuk user yang login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php
// Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('dashboard');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('upload-avatar');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    });
    
    // Dummy routes for quick actions (replace with actual functionality)
    Route::get('/projects/create', function () {
        return redirect()->route('profile.dashboard')->with('info', 'Fitur create project akan segera hadir!');
    })->name('projects.create');
    
    Route::get('/reports', function () {
        return redirect()->route('profile.dashboard')->with('info', 'Fitur reports akan segera hadir!');
    })->name('reports.index');  



// Semua kelas (public)
Route::middleware('auth')->group(function () {
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');
});




/*
|--------------------------------------------------------------------------
| Mentor Routes (Hanya untuk role: guru)
|--------------------------------------------------------------------------
*/
// routes/web.php
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




Route::middleware(['auth', 'role:guru'])->group(function () {

    Route::get('/mentor/pending', [MentorController::class, 'pending'])->name('mentor.pending');
    Route::post('/mentor/approve/{user}', [MentorController::class, 'approve'])->name('mentor.approve');
    Route::post('/mentor/reject/{user}', [MentorController::class, 'reject'])->name('mentor.reject');
});

Route::get('/mentor/{id}', function ($id) {
    return "Profile mentor ID: " . $id;
})->name('mentor.profile');


// Auth routes (login, register, forgot password, dll)
require __DIR__ . '/auth.php';
