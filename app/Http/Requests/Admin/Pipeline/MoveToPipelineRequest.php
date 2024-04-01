<?php

namespace App\Http\Requests\Admin\Pipeline;

use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\Membership;
use App\DataHolders\Enum\PipelineSortingEvent;
use App\Http\Rules\Admin\CheckUserFormPattern;
use App\Models\Pipeline;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MoveToPipelineRequest extends FormRequest
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
            //'event' => ['required', Rule::in(PipelineSortingEvent::onlyNames())],
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
