<?php

namespace App\Http\Requests\Admin\Lead;


use App\Http\Rules\Admin\HasSameLeadStatus;
use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
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
            'lead_id'           => 'required',
            'lead_status_id'    => [
                'required',
                'exists:lead_status,id',
                new HasSameLeadStatus($this->get('lead_id')),
            ],
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
            'lead_id.required' => trans('Lead is required'),
            'lead_id.exists' => trans('Lead does not exists'),
            'status.required' => trans('Lead status is required'),
            'status.exists' => trans('Lead status does not exists'),
        ];
    }
}
