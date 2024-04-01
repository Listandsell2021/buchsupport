<?php

namespace App\Http\Requests\Admin\Lead;

use App\DataHolders\Enum\LeadStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadObjectionRequest extends FormRequest
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
            'lead_id' => 'required|exists:leads,id',
            'reason'  => 'required',
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
            'reason.required' => trans('Reason for rejection is required'),
        ];
    }
}
