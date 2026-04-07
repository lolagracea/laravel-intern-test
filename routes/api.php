<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HobbyController;

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);

Route::post('/hobbies', [HobbyController::class, 'store']);
Route::delete('/hobbies/{id}', [HobbyController::class, 'destroy']);