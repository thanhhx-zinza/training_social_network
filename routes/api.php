<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['api', 'auth:api'])->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login')->withoutMiddleware('auth:api');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile/update', [ProfileController::class, 'update']);
});
