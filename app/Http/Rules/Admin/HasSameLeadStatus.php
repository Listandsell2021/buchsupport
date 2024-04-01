<?php

namespace App\Http\Rules\Admin;

use App\Helpers\Config\ImageConfig;
use App\Models\Lead;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\File;
use Illuminate\Translation\PotentiallyTranslatedString;

class HasSameLeadStatus implements ValidationRule
{

    private $leadId;

    public function __construct($leadId)
    {
        $this->leadId = $leadId;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure(string): PotentiallyTranslatedString $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $lead = Lead::find($this->leadId);

        if (!$lead) {
            $fail(trans('Lead does not exists'));
        }

        if ($lead->lead_status_id == $value) {
            $fail(trans('Lead cannot update to same status'));
        }
    }
}
