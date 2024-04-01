<?php

namespace App\Http\Requests\Admin\Roles;

use App\Models\AdminRole;
use Illuminate\Foundation\Http\FormRequest;

class ChangeActiveStatusRequest extends FormRequest
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
            'is_active' => 'required',
            'role_id' => 'required|exists:'.(new AdminRole())->getTable().',id',
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
            'role_id.required' => trans('AdminRole is required'),
            'role_id.exists' => trans('AdminRole does not exist'),
            'is_active.required' => trans('Invalid Request'),
        ];
    }
}
