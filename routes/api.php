<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\FacilityController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\RoomFeatureController;
use App\Http\Controllers\API\RoomImageController;
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

        Route::prefix('/facility')->group(function () {
            Route::post('/view', [FacilityController::class, 'view']);
            Route::post('/store', [FacilityController::class, 'store']);
            Route::post('/show/{id}', [FacilityController::class, 'show']);
            Route::post('/update/{id}', [FacilityController::class, 'update']);
            Route::post('/delete/{id}', [FacilityController::class, 'delete']);
        });

        Route::prefix('/room')->group(function () {
            Route::post('/view', [RoomController::class, 'view']);
            Route::post('/store', [RoomController::class, 'store']);
            Route::post('/show/{id}', [RoomController::class, 'show']);
            Route::post('/update/{id}', [RoomController::class, 'update']);
            Route::post('/delete/{id}', [RoomController::class, 'delete']);

            Route::prefix('/feature')->group(function () {
                Route::post('/store', [RoomFeatureController::class, 'store']);
                Route::post('/delete/{id}', [RoomFeatureController::class, 'delete']);
            });

            Route::prefix('/image')->group(function () {
                Route::post('/store', [RoomImageController::class, 'store']);
                Route::post('/delete/{id}', [RoomImageController::class, 'delete']);
            });
        });
    });
});
