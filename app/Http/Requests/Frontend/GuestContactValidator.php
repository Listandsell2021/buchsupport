<?php

namespace App\Http\Requests\Frontend;


use App\Http\Rules\Frontend\CheckUserExist;
use Illuminate\Foundation\Http\FormRequest;

class GuestContactValidator extends FormRequest
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
            'user_id'       => ['nullable', new CheckUserExist()],
            'callback_number' => 'required',
            'callback_agree' => 'required',
            'callback_note' => 'nullable',
            'privacy_policy' => 'required',
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
            'user_id.numeric' => 'Die Benutzer-ID muss eine Zahl sein',
            'user_id.exists' => 'Ungültige Benutzer-Id',
            'callback_number.required' => 'Rückrufnummer ist erforderlich',
            'callback_number.min' => 'Rückrufnummer sollte mindestens 7 Nummern sein',
            'callback_agree.min' => 'Notiz muss mindestens 14 Zeichen lang sein.',
            'callback_agree.required' => 'Rückrufvereinbarung muss unterzeichnet werden',
            'privacy_policy.required' => 'Datenschutzerklärung muss unterschrieben werden',
        ];
    }

    public function getRedirectUrl()
    {
        $isContactPage = (bool) (strpos(url()->previous(), 'rueckruf') !== false);

        $previousUrl = url()->previous().(!$isContactPage ? '#main-footer' : '');

        return $previousUrl;
    }
}
