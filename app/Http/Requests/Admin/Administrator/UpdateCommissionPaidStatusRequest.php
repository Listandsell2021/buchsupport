<?php

namespace App\Http\Requests\Admin\Administrator;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommissionPaidStatusRequest extends FormRequest
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
            'commission_id' => 'required|exists:admin_commissions,id',
            'paid'          => 'required|boolean',
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
            'commission_id.required' => trans('Admin Commission is required'),
            'commission_id.exists' => trans('Admin Commission does not exist'),
            'paid.required' => trans('Invalid Request'),
            'paid.boolean' => trans('Invalid Request'),
        ];
    }
}
