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

class CreateUserBookInquiryRequest extends FormRequest
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
    public function rules()
    {
        return [
            'user_id'       => 'required|exists:users,id',
            'product_id'    => 'required|exists:products,id',
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
            'user_id.required'      => 'Die Benutzer-ID muss eine Zahl sein',
            'user_id.exists'        => 'Ungültige Benutzer-Id',
            'product_id.required'   => 'Produkt ist erforderlich',
            'product_id.exists'     => 'Produkt existiert nicht',
        ];
    }
}
