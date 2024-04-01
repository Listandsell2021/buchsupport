<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;


class CreateInquiryForBookSellingValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'productId' => 'required|exists:products,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone'     => 'required|string',
            'email'     => 'required|string',
            'price'     => 'nullable|numeric',
            'terms'     => 'required',
        ];
    }

    /**
     * Get the Messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [

        ];
    }
}
