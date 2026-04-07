<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HobbyController;

Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
});

Route::prefix('hobbies')->controller(HobbyController::class)->group(function () {
    Route::post('/', 'store');
    Route::delete('/{id}', 'destroy');
});