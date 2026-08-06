<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndustryTypeController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

// Public routes
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/services', [FrontendController::class, 'services'])->name('services');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/upload-resume', [FrontendController::class, 'uploadResume'])->name('upload-resume');
Route::get('/jobs', [FrontendController::class, 'index'])->name('jobs.public.index');
Route::get('/jobs/{job_code}', [FrontendController::class, 'show'])->name('jobs.public.show');
Route::post('/apply', [JobApplicationController::class, 'store'])->name('jobs.public.apply');

// Admin Login
Route::get('/admin/login', function () {
    return view('admin.auth.login');
})->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Dashboard & CRUDs
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('industry-types', IndustryTypeController::class);
    Route::resource('job-types', JobTypeController::class);
    Route::resource('job-categories', JobCategoryController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('jobs', JobController::class);
    Route::resource('job-applications', JobApplicationController::class);
    Route::resource('skills', SkillController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
});
