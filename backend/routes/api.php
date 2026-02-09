<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\ProfileController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (prefixed with /api/v1)
|--------------------------------------------------------------------------
*/

// ---- Public Routes ----
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

// ---- Authenticated Routes ----
Route::middleware('auth:sanctum')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/logout', [ProfileController::class, 'logout']);

    // ---- Admin Routes ----
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Will be implemented in admin feature
    });

    // ---- Instructor Routes ----
    Route::middleware('role:instructor')->prefix('instructor')->group(function () {
        // Will be implemented in instructor feature
    });

    // ---- Student Routes ----
    Route::middleware('role:student')->prefix('student')->group(function () {
        // Will be implemented in student feature
    });
});
