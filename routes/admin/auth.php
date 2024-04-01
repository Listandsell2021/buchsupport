<?php

use App\Http\Controllers\API\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\API\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\API\Admin\Auth\NewPasswordController;
use App\Http\Controllers\API\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\API\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\API\Admin\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Helpers\Trait\ApiResponseHelpers;

Route::prefix('admin')->group(function () {

    /*Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest')
        ->name('admin.register');*/

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('admin.login');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:admin')
        ->name('admin.logout');

    /*Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('admin.password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('admin.password.store');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['auth:admin', 'signed', 'throttle:6,1'])
        ->name('admin.verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:admin', 'throttle:6,1'])
        ->name('admin.verification.send');*/


    Route::get('user-detail', function (\Illuminate\Http\Request $request) {

        $user = getAuthAdmin();

        if ($user) {
            $user = new \App\Http\Resources\Admin\AdminRoleResource($user);
        }

        return response()->json($user);

    })->middleware('auth:admin');

});

