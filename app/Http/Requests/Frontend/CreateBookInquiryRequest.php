<?php

namespace App\Http\Requests\Frontend;

use App\Helpers\Config\BuchConfig;
use App\Helpers\Config\ImageConfig;
use App\Http\Rules\Admin\AvoidProductImageIfExist;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateBookInquiryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone'     => 'required|string',
            'email'     => 'required|string',
            'price'     => 'nullable|numeric',
            'terms'     => 'required',
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
            'user_id.required'      => trans('Customer is required'),
            'user_id.exists'        => trans('Customer does not exists'),
            'product_id.required'   => trans('Product is required'),
            'product_id.exists'     => trans('Product does not exists'),
            'first_name.required'   => trans('First name is required'),
            'last_name.required'    => trans('Last name is required'),
            'phone.required'     => trans('Phone no is required'),
            'email.required'        => trans('Email is required'),
            'terms.required'        => trans('Terms is not checked'),
        ];
    }
}
