<?php
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class);
Route::get('users/{user}/posts', [PostController::class, "index"])->name("users.posts.index");
