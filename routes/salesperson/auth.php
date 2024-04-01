<?php

use App\Http\Controllers\API\Salesperson\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::prefix('salesperson')->group(function () {

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('salesperson.login');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:sanctum')
        ->name('salesperson.logout');
});


