<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    //Route::get('/users/{id}', [UserController::class, 'show']);
//    Route::get('/users', [UserController::class, 'index']);
//    Route::post('/users', [UserController::class, 'store']);
});

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('v1')->group(function () {
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
    });
});
