<?php

namespace App\Http\Requests\Frontend;

use App\Rules\Admin\Customer\AvoidIdenticalCustomer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRegistrationValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => ['required', Rule::in(getGenderValues())],
            'address' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'country' => 'required',
            'password' => ['required', 'confirmed', 'min:8', 'max:20'],
            'password_confirmation' => 'required',
            'dob' => [
                'bail', 'required', 'date_format:"d.m.Y"',
                new AvoidIdenticalCustomer(
                    $this->get('first_name'),
                    $this->get('last_name'),
                    $this->get('dob')
                )
            ],
            'membership_id' => ['nullable', 'exists:memberships,id'],
        ];
    }

    /**
     * Get the Messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'dob.birth' => 'Geburtsdatum ist ungültig',
        ];
    }
}
