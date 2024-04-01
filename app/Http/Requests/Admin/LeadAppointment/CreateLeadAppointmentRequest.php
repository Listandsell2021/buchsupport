<?php

namespace App\Http\Requests\Admin\LeadAppointment;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeadAppointmentRequest extends FormRequest
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
            'start_at'      => 'required',
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
            'lead.required'     => trans('Lead is required'),
            'lead.exists'       => trans('Lead does not exists'),
        ];
    }
}
