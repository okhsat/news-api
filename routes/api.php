<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SyncLogController;

Route::apiResource('sources', SourceController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('articles', ArticleController::class);
Route::apiResource('sync-logs', SyncLogController::class);