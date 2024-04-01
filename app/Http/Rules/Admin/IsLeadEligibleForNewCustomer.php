<?php

namespace App\Http\Rules\Admin;


use App\DataHolders\Enum\Membership;
use App\Helpers\Config\ContractDocConfig;
use App\Models\Lead;
use App\Models\LeadContract;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\File;

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
        $pass = true;

        $lead = Lead::find($leadId);

        if (!$lead) {
            $this->addMessageList('Lead does not exists');
            $fail($this->message());
        }

        if ($lead->is_converted) {
            $this->addMessageList('Customer already exists');
            $pass = false;
        }

        if (!$lead->salesperson_id) {
            $this->addMessageList('Salesperson does not exists');
            $pass = false;
        }

        if (!$pass) {
            $fail($this->message());
        }

        $leadContract = LeadContract::withCount('product_items')->where('lead_id', $leadId)->first();

        if (!in_array($leadContract->membership, Membership::onlyNames())) {
            if (!in_array(request()->input('membership'), Membership::onlyNames())) {
                $this->addMessageList('Membership is required');
                $pass = false;
            }
        }

        if (!$pass) {
            $fail($this->message());
        }

        if (empty($leadContract->document_name)) {
            if (!$this->isValidMembershipContractFile()) {
                $pass = false;
            }
        }

        if (!$pass) {
            $fail($this->message());
        }

        if ((int) $leadContract->product_items_count == 0) {
            $contractProduct = new CheckContractProductsPattern();
            if (!($contractProduct->passes('', (array) request()->input('products')))) {
                $this->message .= $contractProduct->getOnlyMessage();
                $pass = false;
            }
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


    /**
     * Validate Contract file
     *
     * @return bool
     */
    protected function isValidMembershipContractFile(): bool
    {
        $document = request()->file('document');

        if (!$document) {
            $this->addMessageList('Document is required');
            return false;
        }

        if (!in_array($document->getClientOriginalExtension(), ContractDocConfig::fileExtensions())) {
            $this->addMessageList('Document must be of type: '.implode(',', ContractDocConfig::fileExtensions()));
            return false;
        }


        $fileSize = getFileSizeInKb((int) $document->getSize());

        if ($fileSize < ContractDocConfig::minFileSize()) {
            $this->addMessageList('Document must be of minimum '.ContractDocConfig::minFileSize().' kb');
            return false;
        }

        if ($fileSize > ContractDocConfig::maxFileSize()) {
            $this->addMessageList('Document must be of maximum '.ContractDocConfig::maxFileSize().' kb');
            return false;
        }

        return true;
    }

}
