<?php

namespace App\Http\Rules\Admin;

use App\DataHolders\Enum\AdminPermission;
use App\Models\Lead;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ExistLeads implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $leadIds
     * @return bool
     */
    public function passes($attribute, mixed $leadIds): bool
    {
        return (bool) Lead::whereIn('id', $leadIds)->count();
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Leads do not exist');
    }
}
