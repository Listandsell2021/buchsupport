<?php

namespace App\Http\Rules\Admin;

use App\DataHolders\Enum\AdminPermission;
use App\Models\Lead;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class AvoidConvertedLead implements Rule
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
        $lead = Lead::find((int) $leadId);

        if (!$lead) {
            $this->message = __('Lead does not exists');
            return false;
        }

        if ($lead->is_converted) {
            $this->message = __('Lead already converted to Customer');
            return false;
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
        return $this->message;
    }
}
