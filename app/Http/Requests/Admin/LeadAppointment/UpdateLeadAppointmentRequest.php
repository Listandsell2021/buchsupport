<?php

namespace App\Http\Requests\Admin\LeadAppointment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadAppointmentRequest extends FormRequest
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
            'id' => 'required|exists:lead_appointments,id',
            'description' => 'required',
            'start_at' => ['required']
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
            'id.required' => trans('Product Category does not exist'),
            'name.required' => trans('Product Category name is required'),
            'is_active.required' => trans('Category Status is required'),
        ];
    }
}
