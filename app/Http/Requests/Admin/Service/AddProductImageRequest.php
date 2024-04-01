<?php

namespace App\Http\Requests\Admin\Service;

use App\Helpers\Config\ImageConfig;
use App\Http\Rules\Admin\AvoidProductImageIfExist;
use Illuminate\Foundation\Http\FormRequest;

class AddProductImageRequest extends FormRequest
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
            'product_id'    => 'required|exists:products,id',
            'image'         => [
                'required',
                'mimes:'.implode(',', ImageConfig::getImageExtensions()),
                new AvoidProductImageIfExist((int) $this->get('product_id')),
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
            'product_id.required'   => trans('Product ID is required'),
            'product_id.exist'      => trans('Product does not exist'),
            'image.required'        => trans('Image is required'),
            'image.mimes'           => trans('Image must be of types').' '.implode(',', ImageConfig::getImageExtensions()),
        ];
    }
}
