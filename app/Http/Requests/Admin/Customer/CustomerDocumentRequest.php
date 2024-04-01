<?php

namespace App\Http\Requests\Admin\Customer;

use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\Membership;
use App\Http\Rules\Admin\CheckUserFormPattern;
use App\Rules\Admin\Customer\CheckFormularPattern;
use Illuminate\Foundation\Http\FormRequest;

class CustomerDocumentRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
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
            'user_id.required' => trans('Customer is required'),
            'user_id.exists' => trans('Customer does not exists'),
        ];
    }
}
