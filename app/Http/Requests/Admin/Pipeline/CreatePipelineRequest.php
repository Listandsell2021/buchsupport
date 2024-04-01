<?php

namespace App\Http\Requests\Admin\Pipeline;

use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\Membership;
use App\Http\Rules\Admin\CheckUserFormPattern;
use App\Models\Pipeline;
use Illuminate\Foundation\Http\FormRequest;

class CreatePipelineRequest extends FormRequest
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
            'name' => ['required', 'max:200', 'unique:'.(new Pipeline())->getTable().',name'],
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
            'name.required' => trans('Pipeline name is required'),
            'name.max' => trans('Pipeline name must not exceed 200 characters'),
            'name.unique' => trans('Pipeline name already taken'),
        ];
    }
}
