<?php

namespace App\Http\Requests\Customer\Profile;

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

class UpdateProfileImageRequest extends FormRequest
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
            'user_id'        => ['required',],
            'image'         => [
                'required',
                'mimes:'.implode(',', BuchConfig::getUserImageExtensions()),
                'max:'.BuchConfig::getUserProfileImageMaxSize(),
                function (string $attribute, mixed $image, \Closure $fail) {
                    $user = User::find($this->get('user_id'));

                    if (!$user) {
                        $fail(trans('Customer does not exists'));
                    }

                    $imagePath = BuchConfig::getUserProfileAbsolutePath($user->id.DIRECTORY_SEPARATOR.$image->getClientOriginalName());

                    if (File::exists($imagePath)) {
                        $fail(trans('Image name already exists'));
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
            'user_id.required'  => trans('Customer is required'),
            'user_id.exists'    => trans('Customer does not exists'),
            'image.required'    => trans('Image file is required'),
            'image.mimes'       => trans('Image file must of types: '.implode(',', BuchConfig::getUserImageExtensions())),
            'image.max'         => trans('Image must not exceed').' '.BuchConfig::getUserProfileImageMaxSize().' KB',
        ];
    }
}
