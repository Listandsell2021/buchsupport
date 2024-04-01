<?php

namespace App\Http\Requests\Admin\LeadDocument;

use App\Helpers\Config\BuchConfig;
use App\Helpers\Config\ImageConfig;
use App\Http\Rules\Admin\AvoidProductImageIfExist;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateLeadDocumentRequest extends FormRequest
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
            'lead_id'   => 'required|exists:leads,id',
            'document'  => [
                'required',
                'mimes:'.implode(',', BuchConfig::getLeadDocumentExtensions()),
                'max:'.BuchConfig::getLeadDocumentMaxSize(),
                function (string $attribute, UploadedFile $image, Closure $fail) {
                    $documentName = $image->getClientOriginalName();
                    $documentPath = BuchConfig::getLeadDocumentAbsolutePath($this->get('lead_id').DIRECTORY_SEPARATOR.$documentName);
                    if (File::exists($documentPath)) {
                        $fail($documentName." already exists");
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
            'lead_id.required'  => trans('Lead is required'),
            'lead_id.exists'    => trans('Lead does not exists'),
            'document.required' => trans('Lead document is required'),
            'document.mimes'    => trans('Lead document extension must be '.implode(',', BuchConfig::getLeadDocumentExtensions())),
            'document.max'      => trans('Lead document must be not be exceed 1 MB'),
        ];
    }
}
