<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AvatarController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('password', [PasswordController::class, 'updatePassword']);

    Route::get('/user', [UserController::class, 'show']);

    Route::apiResource('users', UserController::class);
    Route::post('avatar', [AvatarController::class, 'store']);

    Route::get('roles', [RoleController::class, 'index']);
    Route::get('roles/{role}', [RoleController::class, 'show']);
});


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login',]);

/*
 * Password routes
 */
Route::middleware('guest')->namespace('Users')->prefix('/password')->group(function () {
    Route::post('/forgot', [PasswordController::class, 'sendPasswordResetLink'])->name('password.email');
    Route::post('reset', [PasswordController::class, 'resetPassword'])->name('password.update');
});
