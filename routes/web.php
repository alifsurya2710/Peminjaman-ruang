<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\FloorPlanController;

// Public Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('throttle:60,1');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:60,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Protected Routes (Harus Login)
Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'destroyAvatar'])->name('profile.avatar.destroy');


    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']);

    // Users Management (Admin Only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Rooms Management (Admin & Sarpras & Toolman)
    Route::middleware('role:admin,sarpras,toolman')->group(function () {
        Route::resource('rooms', RoomController::class);
    });

    // Borrowers Management (Admin & Sarpras & Toolman)
    Route::middleware('role:admin,sarpras,toolman')->group(function () {
        Route::resource('borrowers', BorrowerController::class);
        Route::post('/borrowers/{borrower}/approve', [BorrowerController::class, 'approve'])->name('borrowers.approve');
        Route::post('/borrowers/{borrower}/reject', [BorrowerController::class, 'reject'])->name('borrowers.reject');
    });

    // Schedules Management (Admin & Sarpras & Toolman)
    Route::middleware('role:admin,sarpras,toolman')->group(function () {
        Route::resource('schedules', ScheduleController::class);
    });

    // Reports (Admin & Sarpras & Toolman)
    Route::middleware('role:admin,sarpras,toolman')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/borrowers-pdf', [ReportController::class, 'borrowersPdf'])->name('reports.borrowers-pdf');
        Route::get('/reports/borrowers-excel', [ReportController::class, 'borrowersExcel'])->name('reports.borrowers-excel');
        Route::get('/reports/schedules-pdf', [ReportController::class, 'schedulesPdf'])->name('reports.schedules-pdf');
        Route::get('/reports/schedules-excel', [ReportController::class, 'schedulesExcel'])->name('reports.schedules-excel');
    });

    Route::middleware('role:admin,sarpras')->group(function () {
        Route::resource('halls', HallController::class);
    });

    Route::middleware('role:admin,sarpras,toolman')->group(function () {
        Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
        Route::get('/history/{borrower}', [HistoryController::class, 'show'])->name('history.show');
    });

    // Floor Plans (All roles can see, only Admin can manage)
    Route::get('/floor-plans', [FloorPlanController::class, 'index'])->name('floor-plans.index');
    Route::get('/floor-plans/{floorPlan}/download', [FloorPlanController::class, 'download'])->name('floor-plans.download');
    
    Route::middleware('role:admin')->group(function () {
        Route::get('/floor-plans/create', [FloorPlanController::class, 'create'])->name('floor-plans.create');
        Route::post('/floor-plans', [FloorPlanController::class, 'store'])->name('floor-plans.store');
        Route::get('/floor-plans/{floorPlan}/edit', [FloorPlanController::class, 'edit'])->name('floor-plans.edit');
        Route::put('/floor-plans/{floorPlan}', [FloorPlanController::class, 'update'])->name('floor-plans.update');
        Route::delete('/floor-plans/{floorPlan}', [FloorPlanController::class, 'destroy'])->name('floor-plans.destroy');
    });
});
