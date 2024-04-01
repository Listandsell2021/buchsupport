<?php

namespace App\Http\Requests\Admin\LeadTask;

use Illuminate\Foundation\Http\FormRequest;

class DeleteLeadTaskRequest extends FormRequest
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
            'task_id' => 'required|exists:lead_tasks,id',
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
            'task_id.required'  => trans('Lead task is required'),
            'task_id.exists'    => trans('Lead task does not exists'),
        ];
    }
}
