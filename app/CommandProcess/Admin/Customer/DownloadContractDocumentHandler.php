<?php

namespace App\CommandProcess\Admin\Customer;


use App\Helpers\Config\ContractDocConfig;
use App\Models\LeadContract;
use App\Services\Admin\CustomerService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DownloadContractDocumentHandler implements Handler
{
    private CustomerService $leadService;

    public function __construct(CustomerService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $contract = $this->leadService->getContractByCustomerId($command->customerId);

        $filePath = Storage::disk(ContractDocConfig::storageDisk())->path($contract->document_path);

        return response()->download($filePath, $contract->document_name);
    }
}
