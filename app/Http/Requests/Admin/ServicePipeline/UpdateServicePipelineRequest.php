<?php

namespace App\Http\Requests\Admin\ServicePipeline;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServicePipelineRequest extends FormRequest
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
            'id'            => ['required', 'exists:service_pipelines,id'],
            'name'          => ['required', Rule::unique('service_pipelines')->ignore($this->get('id'))],
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
            'id.required'           => trans('Service status does not exist'),
            'name.required'         => trans('Service status name is required'),
            'name.unique'           => trans('Service status name already exists'),
            'has_tracking.required' => trans('Tracking field is required'),
            'default.required'      => trans('Default field is required'),
        ];
    }
}
