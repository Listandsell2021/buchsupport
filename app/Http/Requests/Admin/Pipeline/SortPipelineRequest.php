<?php

namespace App\Http\Requests\Admin\Pipeline;

use App\Models\Pipeline;
use Illuminate\Foundation\Http\FormRequest;

class SortPipelineRequest extends FormRequest
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
            'pipeline_id' => ['required', 'exists:'.(new Pipeline())->getTable().',id'],
            'user_ids' => ['array']
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
            'pipeline_id.required' => trans('Pipeline is required'),
            'pipeline_id.exists' => trans('Pipeline does not exists'),
            'user_ids.array' => trans('User ids must be array'),
        ];
    }
}
