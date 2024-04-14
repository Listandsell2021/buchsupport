<?php

namespace App\CommandProcess\Admin\Lead;


use App\Helpers\Config\ContractDocConfig;
use App\Models\LeadContract;
use App\Services\Admin\LeadService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DownloadContractDocumentHandler implements Handler
{
    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $contract = $this->leadService->getContractByLead($command->leadId);

        $filePath = Storage::disk(ContractDocConfig::storageDisk())->path($contract->document_path);

        return response()->download($filePath, $contract->document);
    }
}
