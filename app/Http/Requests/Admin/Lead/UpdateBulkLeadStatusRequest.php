<?php

namespace App\Http\Requests\Admin\Lead;


use App\Models\Admin;
use App\Models\LeadStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBulkLeadStatusRequest extends FormRequest
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
            'lead_status_id' => ['required', 'exists:'.(new LeadStatus())->getTable().',id'],
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
            'lead_status_id.required' => trans('Lead status is required'),
            'lead_status_id.exists' => trans('Lead status does not exists'),
        ];
    }
}
