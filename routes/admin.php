<?php
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, "show"])->name("login.show");
Route::post('login', [AuthController::class, "login"])->name("login.handleLogin");

Route::middleware('adminAuth')->group(function () {
    Route::resource('users.posts', PostController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('users', UserController::class);
    Route::get('dashboard', [DashboardController::class, "index"])->name("dashboard.index");
    Route::get('logout', [AuthController::class, "logout"])->name("admin.logout");
});
