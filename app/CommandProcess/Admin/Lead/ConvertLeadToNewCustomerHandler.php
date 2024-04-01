<?php

namespace App\CommandProcess\Admin\Lead;

use App\DataHolders\Enum\NotificationTypes;
use App\Helpers\Config\ContractDocConfig;
use App\Models\LeadContract;
use App\Models\Notification;
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

    protected function userContractUpdate($customerId, $leadId)
    {
        $leadContract = LeadContract::where('id', $leadId)->first();
        $customerDocumentPath = ContractDocConfig::getCustomerContractRelativePath($customerId.'/'.$leadContract->document_name);
        Storage::disk(ContractDocConfig::storageDisk())->copy($leadContract->document_path, $customerDocumentPath);

        UserContract::create([
            'user_id'       => $customerId,
            'document_name' => $leadContract->document_name,
            'document_path' => $customerDocumentPath,
        ]);
    }
}
