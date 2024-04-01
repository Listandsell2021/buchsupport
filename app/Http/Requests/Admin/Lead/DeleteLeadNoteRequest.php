<?php

namespace App\Http\Requests\Admin\Lead;


use Illuminate\Foundation\Http\FormRequest;

class DeleteLeadNoteRequest extends FormRequest
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
            'note_id' => 'required|exists:lead_notes,id',
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
            'note_id.required' => trans('Lead note does not exists'),
        ];
    }
}
