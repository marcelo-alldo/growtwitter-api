<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class)->except('store');
    Route::delete('/logout', [AuthController::class, 'destroy']);
    Route::resource('/posts', PostController::class);
    Route::apiResource('/likes', LikeController::class);
    Route::apiResource('/follow', FollowerController::class);
});
