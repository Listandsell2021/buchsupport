<?php

namespace App\Http\Requests\Admin\Administrator;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminBulkActionRequest extends FormRequest
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
            'data_ids'  => ['required', 'array'],
            'action'    => ['required', Rule::in(['active', 'inactive', 'delete'])],
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
            'data_ids.required' => trans('Admin selection is required'),
            'data_ids.array'    => trans('Invalid Request'),
            'action.required'   => trans('Bulk Action is required'),
            'action.in'         => trans('Action does not exists'),
        ];
    }
}
