<?php

namespace App\Http\Requests\Admin\SmartList;

use App\Http\Rules\Admin\ExistLeads;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSmartListRequest extends FormRequest
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
            'name' => ['required', Rule::unique('smart_lists')->where(function (Builder $query) {
                return $query->where('admin_id', getAdminId());
            }),],
            'salesperson_id' => ['required'],
            'filters' => ['required'],
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
            'name.required' => trans('Smart list name is required'),
            'name.unique'   => trans('Smart list already exists'),
            'leads_id'      => trans('Leads are required'),
        ];
    }
}
