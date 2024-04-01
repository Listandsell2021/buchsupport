<?php

namespace App\Http\Requests\Admin\LeadStatus;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeadStatusRequest extends FormRequest
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
            'name'      => 'required|unique:lead_status,name',
            'code'      => 'required|unique:lead_status,code',
            'default'   => 'nullable|numeric',
            'order_no'  => 'nullable|numeric'
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
            'name.required'     => trans('Lead status name is required'),
            'name.unique'       => trans('Lead status name is already taken'),
            'code.required'     => trans('Lead status code is required'),
            'code.unique'       => trans('Lead status code is already taken'),
            'default.required'  => __('Lead status default is required'),
        ];
    }
}
