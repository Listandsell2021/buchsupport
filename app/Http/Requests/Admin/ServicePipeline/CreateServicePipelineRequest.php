<?php

namespace App\Http\Requests\Admin\ServicePipeline;

use App\Http\Rules\Admin\CheckProductImages;
use Illuminate\Foundation\Http\FormRequest;

class CreateServicePipelineRequest extends FormRequest
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
            'name'          => ['required', 'unique:service_pipelines'],
            'service_id'    => ['required', 'exists:services,id'],
            'has_tracking'  => 'required',
            'default'       => 'required',
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
            'name.required'         => trans('Service status name is required'),
            'name.unique'           => trans('Service status name already exists'),
            'has_tracking.required'    => trans('Tracking field is required'),
            'default.required'    => trans('Default field is required'),
        ];
    }
}
