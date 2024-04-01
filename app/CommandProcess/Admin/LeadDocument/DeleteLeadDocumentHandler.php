<?php

namespace App\CommandProcess\Admin\LeadDocument;


use App\Helpers\Config\BuchConfig;
use App\Models\LeadDocument;
use App\Services\Admin\LeadDocumentService;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteLeadDocumentHandler implements Handler
{

    private LeadDocumentService $dbService;

    /**
     * @param LeadDocumentService $dbService
     */
    public function __construct(LeadDocumentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $leadDocument = LeadDocument::find($command->documentId);
        $documentPath = BuchConfig::getLeadDocumentRelativePath($leadDocument->lead_id.DIRECTORY_SEPARATOR.$leadDocument->path);

        if (Storage::exists($documentPath)) {
            Storage::delete($documentPath);
        }

        $this->dbService->delete($command->documentId);
    }
}
