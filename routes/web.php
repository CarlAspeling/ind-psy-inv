<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionnaireAttemptController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Questionnaire attempt routes with constraints
Route::get('/questionnaire/{questionnaire}/start', [QuestionnaireAttemptController::class, 'start'])
    ->name('questionnaire.start')
    ->where('questionnaire', '[0-9]+');

Route::get('/questionnaire/attempt/{attempt}', [QuestionnaireAttemptController::class, 'show'])
    ->name('questionnaire.attempt')
    ->where('attempt', '[0-9]+');

Route::post('/questionnaire/attempt/{attempt}/complete', [QuestionnaireAttemptController::class, 'complete'])
    ->name('questionnaire.complete')
    ->where('attempt', '[0-9]+');

Route::get('/feedback/{attempt}', [FeedbackController::class, 'show'])
    ->name('feedback.show')
    ->where('attempt', '[0-9]+');
