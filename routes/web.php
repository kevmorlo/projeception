<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;

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



Route::get('/terms', function () {
    $terms = File::get(resource_path('markdown/terms.md'));
    return Inertia::render('TermsOfService', ['terms' => $terms]);
})->name('terms');

Route::get('/policy', function () {
    $policy = File::get(resource_path('markdown/policy.md'));
    return Inertia::render('PrivacyPolicy', ['policy' => $policy]);
})->name('policy');



Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index')->middleware('auth:sanctum');

Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('auth:sanctum');

// Ne pas placer avant la route create
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show')->middleware('auth:sanctum');

Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store')->middleware('auth:sanctum');

Route::get('/projects/{project}/edit', function () {
    return Inertia::render('Projects/Edit');
})->name('projects.edit')->middleware('auth:sanctum');

Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update')->middleware('auth:sanctum');

Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy')->middleware('auth:sanctum');



Route::get('/teams/{team}/projects', [App\Http\Controllers\TeamProjectController::class, 'index'])->name('team.projects')->middleware('auth:sanctum');



// Route::get('/error', function (Request $request) {
//     return Inertia::render('Errors/Error', $request->all());
// });