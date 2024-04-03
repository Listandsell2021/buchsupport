<?php

namespace App\Http\Requests\Admin\ServicePipeline;

use App\Models\LeadStatus;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class ChangeDefaultRequest extends FormRequest
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
            'model_id' => 'required|exists:service_pipelines,id',
            'is_active' => 'required',
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
            'model_id.required' => trans('Service status is required'),
            'model_id.exists' => trans('Service status does not exists'),
            'is_active.required' => trans('Invalid Request'),
        ];
    }
}

