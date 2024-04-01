<?php

namespace App\CommandProcess\Admin\LeadDocument;


use App\Services\Admin\LeadDocumentService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredLeadDocumentsHandler implements Handler
{

    private LeadDocumentService $dbService;

    public function __construct(LeadDocumentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->searchAndPaginate($command->leadId);
    }
}
