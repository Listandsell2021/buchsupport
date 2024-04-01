<?php

namespace App\Http\Requests\Admin\Lead;

use App\DataHolders\Enum\LeadStatus;
use App\DataHolders\Enum\Membership;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractMembershipRequest extends FormRequest
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
            'lead_id'       => ['required', 'exists:leads,id'],
            'membership'    => ['required', 'in:'.implode(',', Membership::onlyNames())]
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
            'membership.required' => trans('Membership is required'),
            'membership.in' => trans('Membership is not valid'),
        ];
    }
}
