<?php

namespace App\Http\Requests\Admin\LeadStatus;

use App\Models\LeadStatus;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class ChangeDefaultLeadStatusRequest extends FormRequest
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
            'status_id' => 'required|exists:lead_status,id',
            'default'   => ['required', function (string $attribute, mixed $value, Closure $fail) {

                $leadStatus = LeadStatus::where('id', $this->get('status_id'))->first();

                if ($leadStatus->default == 1 && $value == 0) {
                    $fail(trans('Cannot edit default lead status'));
                }
            }],
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
            'status_id.required' => trans('Lead status is required'),
            'status_id.exists' => trans('Lead status does not exists'),
            'default.required' => trans('Invalid Request'),
        ];
    }
}

