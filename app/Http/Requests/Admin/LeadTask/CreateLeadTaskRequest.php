<?php

namespace App\Http\Requests\Admin\LeadTask;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeadTaskRequest extends FormRequest
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
            'lead_id'       => 'required|exists:leads,id',
            'description'   => 'required',
            'due_at'        => 'required',
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
            'lead_id.required'     => trans('Lead is required'),
            'lead_id.exists'       => trans('Lead does not exists'),
            'description.required' => trans('Lead task description is required'),
            'due_at.required'      => trans('Lead task due date is required'),
        ];
    }
}
