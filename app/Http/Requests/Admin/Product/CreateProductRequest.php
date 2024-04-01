<?php

namespace App\Http\Requests\Admin\Product;

use App\Http\Rules\Admin\CheckProductImages;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'lead_id'       => ['required', 'exists:leads,id'],
            'category_id'   => 'nullable|exists:product_categories,id',
            'name'          => 'required|unique:products',
            'description'   => 'nullable',
            'youtube_link'  => 'nullable',
            'images'        => ['nullable', 'array', new CheckProductImages()],
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
            'category_id.exists'    => __('Product category does not exists'),
            'name.required'         => trans('Product name is required'),
            'name.unique'           => trans('Product name already exists'),
        ];
    }
}
