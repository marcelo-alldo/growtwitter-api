<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/users', [UserController::class, 'store']);

Route::post('/login', [AuthController::class, 'store']);

Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/users', UserController::class )-> except('store');
    Route::apiResource('/login', AuthController::class)-> except('store');
    Route::resource('/posts', PostController::class);
    Route::apiResource('/likes', LikeController::class);
    Route::get('/reports/user', [ReportController::class, 'user']);
});
