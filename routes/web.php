<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController;

// Controllers
use App\Http\Controllers\Admin\TestController as AdminTestController;
use App\Http\Controllers\Admin\TestResultController as AdminTestResultController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CourseController;

// Admin Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes (Laravel UI)
Auth::routes(['verify' => true]);

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// User Routes (Authenticated)
Route::middleware(['auth', 'verified'])->group(function () {

    // Courses
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

    // Tests
    Route::get('/tests/{test}', [TestController::class, 'show'])->name('tests.show');
    Route::post('/tests/{test}/submit', [TestController::class, 'submit'])->name('tests.submit');
    Route::get('/test-results/{result}', [TestController::class, 'result'])->name('test.result');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Course Management
    Route::resource('courses', AdminCourseController::class);

    // Test Management
    Route::resource('tests', AdminTestController::class);

    // Test Questions Management
    Route::get('/tests/{test}/questions', [AdminTestController::class, 'questions'])->name('tests.questions');
    Route::get('/tests/{test}/questions/create', [AdminTestController::class, 'createQuestion'])->name('tests.questions.create');
    Route::post('/tests/{test}/questions', [AdminTestController::class, 'storeQuestion'])->name('tests.questions.store');
    Route::get('/tests/{test}/questions/{question}/edit', [AdminTestController::class, 'editQuestion'])->name('tests.questions.edit');
    Route::put('/tests/{test}/questions/{question}', [AdminTestController::class, 'updateQuestion'])->name('tests.questions.update');
    Route::delete('/tests/{test}/questions/{question}', [AdminTestController::class, 'destroyQuestion'])->name('tests.questions.destroy');

    // User Management
    Route::resource('users', AdminUserController::class);

    // Test Results Management
    Route::get('/test-results', [AdminTestResultController::class, 'index'])->name('test-results.index');
    Route::get('/test-results/{result}', [AdminTestResultController::class, 'show'])->name('test-results.show');
    Route::post('/test-results/{result}/review', [AdminTestResultController::class, 'review'])->name('test-results.review');
});

// Fallback route for 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
