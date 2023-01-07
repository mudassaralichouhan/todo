<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ToDoController;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::controller(UserController::class)->group(function () {
    Route::post('login', 'login')->middleware('verified');
    Route::post('register', 'register');

    Route::controller(VerificationController::class)
        ->prefix('email')->group(function () {
            Route::get('verify/{id}', 'verify')->name('verification.verify');
            Route::get('verified/{id}', 'verified')->name('verification.verified');
            Route::post('resend', 'resend')->name('verification.resend');
            Route::get('notice', 'notice')->name('verification.notice');
        });
});

Route::middleware(['jwt.verify', 'verified'])->group(function() {
    Route::prefix('auth')
        ->controller(AuthController::class)
        ->group(function () {
            Route::post('logout', 'logout');
            Route::get('user', 'user');
    });

    Route::prefix('todo')
        ->controller(ToDoController::class)
        ->group(function () {
            Route::get('', 'index');
            Route::get('{id}', 'show');
            Route::post('', 'store');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'destroy');
        });
});
