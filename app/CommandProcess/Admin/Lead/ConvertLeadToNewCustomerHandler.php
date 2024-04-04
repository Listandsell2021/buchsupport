<?php

namespace App\CommandProcess\Admin\Lead;

use App\Helpers\Config\ContractDocConfig;
use App\Models\LeadContract;
use App\Models\UserContract;
use App\Services\Admin\LeadService;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class ConvertLeadToNewCustomerHandler implements Handler
{

    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $customer = $this->leadService->convertLeadToNewCustomer($command->leadId);

        $this->userContractUpdate($customer->id, $command->leadId);
    }

    protected function userContractUpdate($customerId, $leadId): void
    {
        $leadContract = LeadContract::where('lead_id', $leadId)->first();
        $customerDocumentPath = ContractDocConfig::getCustomerContractRelativePath($customerId.'/'.$leadContract->document_name);
        Storage::disk(ContractDocConfig::storageDisk())->copy($leadContract->document_path, $customerDocumentPath);

        UserContract::create([
            'user_id'       => $customerId,
            'service_id'    => $leadContract->service_id,
            'note'          => $leadContract->note,
            'price'         => $leadContract->price,
            'quantity'      => $leadContract->quantity,
            'document'      => $leadContract->document,
            'document_path' => $customerDocumentPath,
        ]);
    }
}
