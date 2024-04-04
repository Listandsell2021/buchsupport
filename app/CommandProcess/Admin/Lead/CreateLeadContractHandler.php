<?php

namespace App\CommandProcess\Admin\Lead;


use App\Helpers\Config\ContractDocConfig;
use App\Models\LeadContract;
use App\Services\Admin\LeadService;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class CreateLeadContractHandler implements Handler
{
    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $folderPath = ContractDocConfig::getLeadContractRelativePath($command->leadId);
        $documentName = $command->document->getClientOriginalName();
        Storage::disk(ContractDocConfig::storageDisk())->putFileAs($folderPath, $command->document, $documentName);
        $documentPath = $folderPath."/".$documentName;

        return $this->leadService->createLeadContract($command->leadId, $command->serviceId, $command->quantity, $command->price, $command->note, $documentName, $documentPath);
    }


}
