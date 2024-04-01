<?php

namespace App\Http\Requests\Admin\Roles;

use App\Models\AdminRole;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'id' => 'required|exists:'.(new AdminRole())->getTable().',id',
            'name' => 'required|unique:'.(new AdminRole())->getTable().',name,'.$this->get('id'),
        ];
    }
}
