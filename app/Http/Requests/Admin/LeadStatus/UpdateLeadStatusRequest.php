<?php

namespace App\Http\Requests\Admin\LeadStatus;

use App\Models\LeadStatus;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadStatusRequest extends FormRequest
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
            'id'        => 'required|exists:lead_status,id',
            'name'      => ['required', Rule::unique('lead_status', 'name')->ignore($this->get('id'))],
            'code'      => ['required', Rule::unique('lead_status', 'code')->ignore($this->get('id'))],
            'default'   => ['required', function (string $attribute, mixed $value, Closure $fail) {

                $leadStatus = LeadStatus::where('id', $this->get('id'))->first();

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
            'id.required'       => trans('Lead status does not exists'),
            'name.required'     => trans('Lead status name is required'),
            'name.unique'       => trans('Lead status name is already taken'),
            'code.required'     => trans('Lead status code is required'),
            'code.unique'       => trans('Lead status code is already taken'),
            'default.required'  => __('Lead status default is required'),
        ];
    }
}
