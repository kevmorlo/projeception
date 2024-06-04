<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});



Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index')->middleware('auth:sanctum');

Route::get('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show')->middleware('auth:sanctum');

Route::get('/projects/create', function () {
    return Inertia::render('Projects/Create');
})->name('projects.create')->middleware('auth:sanctum');

Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store')->middleware('auth:sanctum');

Route::get('/projects/{project}/edit', function () {
    return Inertia::render('Projects/Edit');
})->name('projects.edit')->middleware('auth:sanctum');

Route::put('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'update'])->name('projects.update')->middleware('auth:sanctum');

Route::delete('/projects/{project}', [App\Http\Controllers\ProjectController::class, 'destroy'])->name('projects.destroy')->middleware('auth:sanctum');



Route::get('/teams/{team}/projects', [App\Http\Controllers\TeamProjectController::class, 'index'])->name('team.projects')->middleware('auth:sanctum');
