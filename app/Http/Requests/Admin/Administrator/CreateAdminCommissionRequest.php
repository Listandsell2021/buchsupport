<?php

namespace App\Http\Requests\Admin\Administrator;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminCommissionRequest extends FormRequest
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
            'admin_id'      => 'required|exists:admins,id',
            'date_from'     => 'required|date',
            'date_to'       => 'required|date',
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
            'admin_id.required'  => trans('Admin is required'),
            'admin_id.exists'    => trans('Admin does not exist'),
            'date_from.required' => trans('Date from is required'),
            'date_from.date'     => trans('Date from must be a date'),
            'date_to.required'   => trans('Date to is required'),
            'date_to.date'       => trans('Date to must be a date'),
        ];
    }
}
