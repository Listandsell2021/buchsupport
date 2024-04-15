<?php

namespace App\Http\Requests\Admin\Customer;

use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\Membership;
use App\Http\Rules\Admin\CheckUserFormPattern;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'dob' => 'required|date|before:today',//date_format:'.getLocaleDateFormat()
            'phone_no' => 'nullable',
            'gender' => 'required|in:'.implode(',', Gender::onlyNames()),
            'street' => 'nullable',
            'postal_code' => 'nullable|numeric',
            'city' => 'nullable',
            'country' => 'required',
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
            'dob.date' => trans('Date of birth is invalid'),
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
