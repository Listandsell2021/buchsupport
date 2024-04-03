<?php

namespace App\Http\Requests\Admin\Service;

use App\Http\Rules\Admin\CheckProductImages;
use Illuminate\Foundation\Http\FormRequest;

class CreateServiceRequest extends FormRequest
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
            'name'          => ['required', 'unique:services'],
            'is_active'     => 'required',
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
            'name.required'         => trans('Service name is required'),
            'name.unique'           => trans('Service name already exists'),
            'is_active.required'    => trans('Status is required'),
        ];
    }
}
