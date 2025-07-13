<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserPreferenceController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
    'as' => 'api.',
], function () {

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::middleware('auth:api')->group(function () {
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

// Articles routes
Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');

// Protected routes
Route::middleware('auth:api')->group(function () {
    // Personalized articles
    Route::get('articles/feed', [ArticleController::class, 'personalized'])->name('articles.personalized');

    // User preferences
    Route::get('user/preferences', [UserPreferenceController::class, 'index'])->name('preferences.index');
    Route::put('user/preferences', [UserPreferenceController::class, 'update'])->name('preferences.update');
});
