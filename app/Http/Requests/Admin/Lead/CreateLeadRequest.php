<?php

namespace App\Http\Requests\Admin\Lead;

use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\LeadStatus;
use Illuminate\Foundation\Http\FormRequest;

class CreateLeadRequest extends FormRequest
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
            'email' => 'required|email|unique:leads,email',
            'gender' => 'required|in:'.implode(',', Gender::onlyNames()),
            'phone_no' => 'nullable',
            'street' => 'nullable',
            'postal_code' => 'nullable',
            'city' => 'nullable',
            'country' => 'nullable',
            'map_longitude' => 'nullable',
            'map_latitude' => 'nullable',
            'lead_status_id' => ['required', 'exists:lead_status,id'],
            'salesperson_id' => ['nullable', 'exists:admins,id']
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
            'phone_no.required' => trans('Phone no is required'),
            'postal_code.required' => trans('Postal code is required'),
            'postal_code.numeric' => trans('Postal code must be numbers'),
            'gender.required' => trans('Gender is required'),
            'city.required' => trans('City is required'),
            'country.required' => trans('Country is required'),
            'lead_status_id.required' => trans('Lead status is required'),
            'lead_status_id.exists' => trans('Lead status does not exists'),
            'salesperson_id.exists' => trans('Salesperson does not exists'),
        ];
    }
}
