<?php

namespace App\Http\Requests\Admin\Lead;


use App\Helpers\Config\BuchConfig;
use App\Models\Admin;
use App\Models\LeadStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadTablePreferenceRequest extends FormRequest
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
            'columns' => ['required', 'array',
                function ($attribute, $columns, $fail) {

                    foreach ($columns as $column) {
                        if (!in_array($column, BuchConfig::getLeadTableColumns())) {
                            $fail($column.' does not exists with in Lead table column');
                        }
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
            'columns.required' => trans('Lead columns are required'),
            'columns.array' => trans('Lead columns are invalid'),
        ];
    }
}
