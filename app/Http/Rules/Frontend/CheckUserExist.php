<?php

namespace App\Http\Rules\Frontend;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class CheckUserExist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $userId
     * @return bool
     */
    public function passes($attribute, $userId)
    {
        if ($userId == '' || empty($userId)) {
            return true;
        }

        $trimmedUserId = removeSpace($userId);

        return User::where('uid', $trimmedUserId)->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Benutzer stimmt nicht überein';
    }
}
