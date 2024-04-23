<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index']);

Route::get('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'show']);
// Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'store'])->middleware('auth:sanctum');