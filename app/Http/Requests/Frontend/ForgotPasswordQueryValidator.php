<?php

namespace App\Http\Requests\Frontend;

use App\Http\Rules\Frontend\CheckUserExist;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordQueryValidator extends FormRequest
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
            'user_id' => ['required', new CheckUserExist()],
            'username' => 'required',
            'phone_no' => 'required',
        ];
    }


    public function getRedirectUrl()
    {
        $isContactPage = (bool) (strpos(url()->previous(), 'rueckruf') !== false);

        $previousUrl = url()->previous().(!$isContactPage ? '#main-footer' : '');

        return $previousUrl;
    }

}
