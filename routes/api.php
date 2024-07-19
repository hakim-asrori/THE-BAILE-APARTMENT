<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\EnquireController;
use App\Http\Controllers\API\FacilityController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\RoomFeatureController;
use App\Http\Controllers\API\RoomImageController;
use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\PublicApiMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/test', [TestController::class, 'index']);

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('generate-token', [AuthController::class, 'generateToken']);
        Route::post('check', [AuthController::class, 'check'])->middleware('auth:sanctum');
    });

    Route::middleware([PublicApiMiddleware::class])->prefix('/public')->group(function () {
        Route::post('/subscription/store', [SubscriptionController::class, 'store']);
        Route::post('/contact/store', [ContactController::class, 'store']);
        Route::post('/enquire/store', [EnquireController::class, 'store']);
        Route::post('/facility/view', [FacilityController::class, 'view']);
        Route::post('/room/view', [RoomController::class, 'view']);
        Route::post('/gallery/view', [GalleryController::class, 'view']);
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/dashboard', [DashboardController::class, 'index']);
        Route::prefix('/subscription')->group(function () {
            Route::post('/view', [SubscriptionController::class, 'view']);
            Route::post('/delete/{id}', [SubscriptionController::class, 'delete']);
        });

        Route::prefix('/gallery')->group(function () {
            Route::post('/view', [GalleryController::class, 'view']);
            Route::post('/store', [GalleryController::class, 'store']);
            Route::post('/delete/{id}', [GalleryController::class, 'delete']);
        });

        Route::prefix('/contact')->group(function () {
            Route::post('/view', [ContactController::class, 'view']);
            Route::post('/show/{id}', [ContactController::class, 'show']);
            Route::post('/delete/{id}', [ContactController::class, 'delete']);
        });

        Route::prefix('/enquire')->group(function () {
            Route::post('/view', [EnquireController::class, 'view']);
            Route::post('/show/{id}', [EnquireController::class, 'show']);
            Route::post('/delete/{id}', [EnquireController::class, 'delete']);
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
