<?php

namespace App\Http\Controllers\API\Salesperson\Auth;

use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Salesperson\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    use ApiResponseHelpers;

    public string $guard = 'admin';

    /**
     * Handle an incoming authentication request.
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $user = $request->authenticate();

        $token = $user->createToken($request->get('device_name'))->plainTextToken;

        return response()->json($token);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        /*Auth::guard($this->guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();*/

        return $this->respondWithSuccess(trans('Salesperson logout successfully'), true);
    }
}
