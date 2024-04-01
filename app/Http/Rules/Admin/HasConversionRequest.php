<?php

namespace App\Http\Rules\Admin;


use App\DataHolders\Enum\Membership;
use App\Models\Lead;
use App\Models\LeadContract;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasConversionRequest implements ValidationRule
{
    protected string $message = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function validate(string $attribute, mixed $leadId, Closure $fail): void
    {
        $pass = true;

        $lead = Lead::find($leadId);

        if (!$lead) {
            $this->addMessageList('Lead does not exists');
            $fail($this->message());
        }

        if ($lead->has_conversion_request) {
            $this->addMessageList('This Lead already been requested for customer');
            $pass = false;
        }

        if (!$pass) {
            $fail($this->message());
        }
    }


    public function addMessageList($message): void
    {
        $this->message .= "<li>".$message."</li>";
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "<ul>".$this->message."</ul>";
    }


}
