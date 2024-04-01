<?php

namespace App\Http\Requests\Admin\Lead;


use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBulkLeadSalespersonRequest extends FormRequest
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
            'salesperson_id' => ['required', 'exists:'.(new Admin())->getTable().',id'],
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
            'salesperson_id.required' => trans('Salesperson is required'),
            'salesperson_id.exists' => trans('Salesperson does not exists'),
        ];
    }
}
