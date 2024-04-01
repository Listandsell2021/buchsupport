<?php

namespace App\Http\Requests\Admin\LeadAppointment;

use Illuminate\Foundation\Http\FormRequest;

class DeleteLeadAppointmentRequest extends FormRequest
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
            'appointment_id' => 'required|exists:lead_appointments,id',
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
            'appointment_id.required' => trans('Lead appointment is required'),
            'appointment_id.exists' => trans('Lead appointment does not exists'),
        ];
    }
}
