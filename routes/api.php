<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SyncLogController;

// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']); // optional, if you implement login

Route::middleware('auth:sanctum')->group(function () {
    Route::put('profile', [AuthController::class, 'updateProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('sources', SourceController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('sync-logs', SyncLogController::class);
});