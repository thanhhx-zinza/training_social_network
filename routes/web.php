<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\App\PostController;
use App\Http\Controllers\App\HomeController;
use App\Http\Controllers\App\RelationController;
use App\Http\Controllers\App\SettingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\App\ReactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'registerAccount'])->name('auth.register_account');
Route::get('/error', function () {
    return view('app.error');
})->name('error');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::resource('posts.comments', CommentController::class);

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/relations', [RelationController::class, 'getAddFriendList'])->name('relations.get_add_friend_list');
    Route::post('/relations/{relation}', [RelationController::class, 'addFriend'])->name('relations.add_friend');
    Route::get('/relations/requests', [RelationController::class, 'getRequests'])->name('relations.get_requests');
    Route::patch('/relations/{relation}', [RelationController::class, 'responseRequest'])->name('relations.response_request');

    Route::resource('posts', PostController::class);

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [SettingController::class, 'changeSettings'])->name('settings.change_settings');
    Route::resource('reactions', ReactionController::class);

    Route::post('profile/upload', [ ProfileController::class, 'upload' ])->name('profile.upload');
});
