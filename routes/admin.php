<?php
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManagerAdminController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, "show"])->name("login.show");
Route::post('login', [LoginController::class, "login"])->name("login.handleLogin");

Route::resource('users', UserController::class);
Route::get('users/{user}/posts', [PostController::class, "index"])->name("users.posts.index");

Route::middleware('adminAuth')->group(function () {
    Route::get('dashboard', [DashboardController::class, "index"])->name("dashboard.index");
    Route::prefix("posts")->group(function () {
        Route::get('edit/{user}/{post}', [PostController::class, "edit"])->name("admin.post.edit");
        Route::put('update/{user}/{post}', [PostController::class, "update"])->name("admin.post.update");
        Route::delete('delete/{user}/{post}', [PostController::class, "destroy"])->name("admin.post.delete");
    });
    Route::prefix("list-admin")->group(function () {
        Route::get('index', [ManagerAdminController::class, "index"])->name("admin.subAdmin.index");
        Route::get('create', [ManagerAdminController::class, "create"])->name("admin.subAdmin.create");
        Route::post('store', [ManagerAdminController::class, "store"])->name("admin.subAdmin.store");
        Route::get('edit/{admin}', [ManagerAdminController::class, "edit"])->name("admin.subAdmin.edit");
        Route::put('update/{admin}', [ManagerAdminController::class, "update"])->name("admin.subAdmin.update");
        Route::delete('delete/{admin}', [ManagerAdminController::class, "destroy"])->name("admin.subAdmin.delete");
    });
    Route::get('logout', [LoginController::class, "logout"])->name("admin.logout");
});
