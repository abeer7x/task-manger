<?php

use App\Http\Controllers\api\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\api\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('task',TaskController::class)->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/registerAdmin', [AuthController::class, 'register'])->middleware('auth:sanctum');

Route::apiResource('status',StatusController::class)->middleware('auth:sanctum');