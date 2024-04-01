<?php

namespace App\Http\Requests\Admin\Pipeline;

use App\Models\Pipeline;
use App\Models\User;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class AddCustomerToPipelineRequest extends FormRequest
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
            'user_id' => [
                'required',
                'exists:'.(new User())->getTable().',id',
                function (string $attribute, mixed $value, Closure $fail) {

                    $pipeline = DB::table('pipeline_users')
                        ->join('pipelines', 'pipeline_users.pipeline_id', 'pipelines.id')
                        ->where('user_id', $value)
                        ->first();

                    if ($pipeline) {
                        $fail(trans('Customer already exists in pipeline "'.$pipeline->name.'"'));
                    }
                },
            ],
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
            'user_id.required' => trans('Customer is required'),
            'user_id.exists' => trans('Customer does not exists'),
        ];
    }
}
