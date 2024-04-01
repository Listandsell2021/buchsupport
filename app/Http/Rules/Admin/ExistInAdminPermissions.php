<?php

namespace App\Http\Rules\Admin;

use App\DataHolders\Enum\AdminPermission;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ExistInAdminPermissions implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $permissions
     * @param \Closure(string): PotentiallyTranslatedString $fail
     * @return void
     */
    public function validate(string $attribute, mixed $permissions, Closure $fail): void
    {
        $message = trans('Permissions do not exist');

        if (count($permissions) === 0) {
            $fail($message);
        }

        $adminPermissions = AdminPermission::onlyNames();

        foreach ($permissions as $permission) {
            if (!in_array($permission, $adminPermissions)) {
                $fail($message);
            }
        }
    }
}
