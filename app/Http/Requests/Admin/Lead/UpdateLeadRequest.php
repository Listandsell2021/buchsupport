<?php

namespace App\Http\Requests\Admin\Lead;

use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\LeadStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadRequest extends FormRequest
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
            'id' => 'required|exists:leads,id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', Rule::unique('leads')->ignore($this->get('id'))],
            'gender' => 'required|in:'.implode(',', Gender::onlyNames()),
            'phone_no' => 'required',
            'street' => 'nullable',
            'postal_code' => 'required|numeric',
            'city' => 'nullable',
            'country' => 'required',
            'map_longitude' => 'required',
            'map_latitude' => 'required',
            'lead_status_id' => ['required', 'exists:lead_status,id'],
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
            'email.email' => trans('Email is invalid'),
            'email.unique' => trans('Email is already taken'),
            'phone_no.required' => trans('Phone no is required'),
            'gender.required' => trans('Gender is required'),
            'city.required' => trans('City is required'),
            'country.required' => trans('Country is required'),
            'lead_status_id.required' => trans('Lead status is required'),
            'lead_status_id.exists' => trans('Lead status does not exists'),
        ];
    }
}
