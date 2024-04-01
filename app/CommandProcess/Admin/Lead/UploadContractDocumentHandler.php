<?php

namespace App\CommandProcess\Admin\Lead;


use App\Helpers\Config\ContractDocConfig;
use App\Models\LeadContract;
use App\Services\Admin\LeadService;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UploadContractDocumentHandler implements Handler
{
    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $contract = $this->leadService->getContractByLead($command->leadId);

        $path = $contract->document_path ?? '';

        if (Storage::disk(ContractDocConfig::storageDisk())->exists($path)) {
            Storage::disk(ContractDocConfig::storageDisk())->delete($path);
        }

        $this->updateContract($command);
    }


    private function updateContract($command): void
    {
        $documentName = $command->document->getClientOriginalName();
        $folderPath = ContractDocConfig::getLeadContractRelativePath($command->leadId);
        Storage::disk(ContractDocConfig::storageDisk())->putFileAs($folderPath, $command->document, $documentName);
        $this->leadService->updateContractDocument($command->leadId, $documentName, $folderPath."/".$documentName);
    }
}
