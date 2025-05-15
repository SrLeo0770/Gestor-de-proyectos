<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('projects.index');
    })->name('dashboard');

    // User Management Routes
    Route::resource('users', UserController::class);

    // Project Routes
    Route::resource('projects', ProjectController::class);

    // Report Routes
    Route::prefix('reports')->group(function () {
        Route::get('/created', [ReportController::class, 'createdReports'])->name('reports.created');
        Route::get('/in-progress', [ReportController::class, 'inProgressReports'])->name('reports.inProgress');
        Route::get('/completed', [ReportController::class, 'completedReports'])->name('reports.completed');
        Route::get('/by-leader', [ReportController::class, 'reportsByLeader'])->name('reports.byLeader');
        Route::get('/by-client', [ReportController::class, 'reportsByClient'])->name('reports.byClient');
    });
});
