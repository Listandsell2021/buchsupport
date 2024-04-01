<?php

namespace App\Http\Requests\Customer\Profile;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UpdateUserPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id'               => ['required', 'exists:users,id'],
            'password'          => ['required', 'min:6'],
            'confirm_password'  => ['required', 'same:password'],
        ];
    }


    /**
     * Validation Messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'user_id.required' => trans('Customer is required'),
            'user_id.exists'    => trans('Customer does not exists'),
            'password.required' => trans('Password is required'),
            'password.min'      => trans('Password must be minimum 6 letters'),
            'confirm_password.required'     => trans('Confirm password is required'),
            'confirm_password.same'         => trans('Confirm password must be same as password'),
        ];
    }
}
