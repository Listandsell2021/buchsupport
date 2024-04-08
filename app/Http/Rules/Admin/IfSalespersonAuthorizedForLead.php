<?php

namespace App\Http\Rules\Admin;

use App\Models\Lead;
use Illuminate\Contracts\Validation\Rule;

class IfSalespersonAuthorizedForLead implements Rule
{
    public string $message = '';

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $leadId
     * @return bool
     */
    public function passes($attribute, mixed $leadId): bool
    {
        if (isAuthSalesperson()) {
            return Lead::where('id', $leadId)->where('salesperson_id', getAdminId())->exists();
        }

        return true;
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans("Current salesperson is not authorized for accessing this lead");
    }
}
