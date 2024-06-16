<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/test', [TestController::class, 'index']);

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('check', [AuthController::class, 'check'])->middleware('auth:sanctum');
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('/contact')->group(function () {
            Route::post('/view', [ContactController::class, 'view']);
            Route::post('/store', [ContactController::class, 'store']);
            Route::post('/show/{id}', [ContactController::class, 'show']);
            Route::post('/delete/{id}', [ContactController::class, 'delete']);
        });
    });
});
