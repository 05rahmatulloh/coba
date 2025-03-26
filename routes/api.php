<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\PostController;
// use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



// Route::apiResource('post', PostController::class);

// Route::apiResource('users', UsersController::class);

Route::POST('/register', [AuthController::class,'register']);

Route::POST('/', [AuthController::class,'ambil']);

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::POST('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');
