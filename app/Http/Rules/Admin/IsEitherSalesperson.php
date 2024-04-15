<?php

namespace App\Http\Rules\Admin;

use App\Models\Admin;
use App\Models\Lead;
use Illuminate\Contracts\Validation\Rule;

class IsEitherSalesperson implements Rule
{

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param $adminId
     * @return bool
     */
    public function passes($attribute, $adminId): bool
    {
        if ($adminId == '' || $adminId == null) {
            return true;
        }

        return Admin::where('id', $adminId)->salesperson()->active()->exists();
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans("Salesperson does not exist");
    }
}
