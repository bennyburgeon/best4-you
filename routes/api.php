<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\IndustryTypeController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\RegionController;

Route::name('api.')->group(function () {
    // Auth Routes (Guest)
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Public Routes
    Route::get('/jobs', [JobController::class, 'index']);
    Route::get('/jobs/{job}', [JobController::class, 'show']);
    Route::post('/job-applications', [JobApplicationController::class, 'store']);
    Route::get('/job-categories', [JobCategoryController::class, 'index']);
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/skills', [SkillController::class, 'index']);
    Route::get('/currencies', [CurrencyController::class, 'index']);
    Route::get('/industry-types', [IndustryTypeController::class, 'index']);
    Route::get('/job-types', [JobTypeController::class, 'index']);
    Route::get('/regions', [RegionController::class, 'index']);

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        
        // Dashboard Stats
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
        
        // Admin CRUD routes
        Route::apiResource('job-categories', JobCategoryController::class)->except(['index']);
        Route::apiResource('clients', ClientController::class)->except(['index']);
        Route::apiResource('skills', SkillController::class)->except(['index']);
        Route::apiResource('currencies', CurrencyController::class)->except(['index']);
        Route::apiResource('industry-types', IndustryTypeController::class)->except(['index']);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('users', UserController::class);
        Route::get('permissions', [PermissionController::class, 'index']);
        Route::get('/job-applications', [JobApplicationController::class, 'index']);
        Route::apiResource('regions', RegionController::class)->except(['index']);
        Route::apiResource('jobs', JobController::class)->except(['index', 'show']);
    });
});
