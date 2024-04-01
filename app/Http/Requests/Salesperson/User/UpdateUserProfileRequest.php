<?php

namespace App\Http\Requests\Salesperson\User;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UpdateUserProfileRequest extends FormRequest
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
            'first_name'        => ['required'],
            'last_name'         => ['required'],
            'dob'               => 'required|date|date_format:Y-m-d',
/*            'street'            => ['required'],
            'city'              => ['required'],
            'postal_code'       => ['required'],*/
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
            'id.required'           => trans('Customer is required'),
            'id.exists'             => trans('Customer does not exists'),
            'first_name.required'   => trans('First Name is required'),
            'last_name.required'    => trans('Last Name is required'),
            'dob.required'          => trans('Dob is required'),
            'street.required'       => trans('Street is required'),
            'city.required'         => trans('City is required'),
            'postal_code.required'  => trans('Postal code is required'),
        ];
    }
}
