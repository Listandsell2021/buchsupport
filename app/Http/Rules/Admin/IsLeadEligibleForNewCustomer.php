<?php

namespace App\Http\Rules\Admin;


use App\Models\Lead;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsLeadEligibleForNewCustomer implements ValidationRule
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
        $lead = Lead::find($leadId);

        if (!$lead) {
            $fail(trans('Lead does not exists'));
        }

        if ($lead->is_converted) {
            $fail(trans('Customer already exists'));
        }

        if (!$lead->salesperson_id) {
            $fail(trans('Salesperson does not exists'));
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
