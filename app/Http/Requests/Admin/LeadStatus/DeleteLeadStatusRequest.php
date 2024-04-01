<?php

namespace App\Http\Requests\Admin\LeadStatus;

use App\Models\LeadStatus;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteLeadStatusRequest extends FormRequest
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
            'status_id'        => ['required', function (string $attribute, mixed $value, Closure $fail) {

                $leadStatus = LeadStatus::where('id', $this->get('status_id'))->first();

                if (!$leadStatus) {
                    $fail(trans('Lead status does not exists'));
                }

                if ($leadStatus->default == 1) {
                    $fail(trans('Cannot delete default lead status'));
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
            'status_id.required'     => trans('Lead status is required'),
        ];
    }
}
