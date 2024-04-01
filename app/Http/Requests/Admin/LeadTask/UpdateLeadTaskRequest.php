<?php

namespace App\Http\Requests\Admin\LeadTask;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadTaskRequest extends FormRequest
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
            'id'          => 'required|exists:lead_tasks,id',
            'description' => 'required',
            'due_at'      => ['required']
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
            'id.required'           => trans('Lead task is required'),
            'id.exists'             => trans('Lead task does not exists'),
            'description.required'  => trans('Lead task description is required'),
            'due_at.required'       => trans('Lead due date is required')
        ];
    }
}
