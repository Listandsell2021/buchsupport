<?php

namespace App\Http\Requests\Admin\Administrator;

use App\DataHolders\Enum\AuthRole;
use App\DataHolders\Enum\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAdminRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|min:8',
            'dob'       => 'required|date|date_format:'.getLocaleDateFormat().'|before:today',
            'phone_no' => 'required',
            'gender' => 'required|in:'.implode(',', Gender::onlyNames()),
            'street' => 'nullable',
            'postal_code' => 'nullable',
            'city' => 'nullable',
            'country' => 'required',
            'auth_role' => ['required', Rule::in(AuthRole::onlyNames())],
            'role_id' => ['nullable', 'exists:admin_roles,id'],
            'salesperson_id' => 'nullable|exists:salespersons,id',
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
            'first_name.required' => trans('First name is required'),
            'last_name.required' => trans('Last name is required'),
            'email.required' => trans('Email is required'),
            'email.email' => trans('Email is valid'),
            'email.unique' => trans('Email is already taken'),
            'password.required' => trans('Password is required'),
            'password.confirmed' => trans('Password confirmation does not match'),
            'password.min' => trans('Password must be atleast 8 characters'),
            'dob.required' => trans('Date of birth is required'),
            'dob.date'      => trans('Date of birth is invalid'),
            'dob.date_format' => trans('Date of birth must be in format YYYY-MM-DD'),
            'phone_no.required' => trans('Phone no is required'),
            //'gender.required' => trans('Gender is required'),
            //'city.required' => trans('City is required'),
            'country.required' => trans('Country is required'),
            'role_id.required' => trans('AdminRole is required'),
            'role_id.exists' => trans('AdminRole does not exists'),
        ];
    }
}
