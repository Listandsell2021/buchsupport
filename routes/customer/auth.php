<?php

use App\Http\Controllers\API\Customer\Auth\AuthenticatedSessionController;
use App\Http\Resources\Customer\Profile\UserResource;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('user.login');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('user.logout');

    Route::get('detail', function () {
        $user = getAuthCustomer();

        if (!$user) {
            return response()->json([], 401);
        }

        return response()->json(new UserResource($user));

    })->middleware('auth:web');

});


