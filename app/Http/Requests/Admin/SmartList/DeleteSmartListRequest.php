<?php

namespace App\Http\Requests\Admin\SmartList;

use App\Http\Rules\Admin\ExistLeads;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteSmartListRequest extends FormRequest
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
            'smart_list_id' => ['required', 'exists:smart_lists,id'],
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
            'smart_list_id.required'    => trans('Smart list is required'),
            'smart_list_id.exists'      => trans('Smart list does not exists'),
        ];
    }
}
