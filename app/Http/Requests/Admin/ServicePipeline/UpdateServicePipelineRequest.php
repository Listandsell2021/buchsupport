<?php

namespace App\Http\Requests\Admin\ServicePipeline;

use App\Models\ServicePipeline;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
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
            'id'            => ['required', Rule::exists((new ServicePipeline())->getTable())],
            'service_id'    => ['required'],
            'name'          => ['required',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $pipeline = ServicePipeline::where('service_id', $this->get('service_id'))
                        ->where('id', '<>', $this->get('id'))
                        ->where('name', '=', $value)
                        ->exists();

                    if ($pipeline) {
                        $fail(trans('Status name already exists'));
                    }
                },
            ],
            'has_tracking'  => 'required',
            'default'       => 'required',
            'has_option'    => 'required',
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
            'id.required'           => trans('Status does not exist'),
            'name.required'         => trans('Status name is required'),
            'name.unique'           => trans('Status name already exists'),
            'has_tracking.required' => trans('Tracking field is required'),
            'default.required'      => trans('Default field is required'),
        ];
    }
}
