<?php

namespace App\Http\Requests\Admin\ServicePipeline;

use App\Http\Rules\Admin\CheckProductImages;
use App\Models\ServicePipeline;
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
            'name'          => [
                'required',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $pipeline = ServicePipeline::where('service_id', $this->get('service_id'))
                        ->where('name', '=', $value)
                        ->exists();

                    if ($pipeline) {
                        $fail(trans('Status name ":name" already exists', ['name' => $value]));
                    }
                },
            ],
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
