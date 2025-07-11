<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
    'as' => 'api.',
], function () {
    Route::post('/login', [AuthController::class, 'login']);
});
