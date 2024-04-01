<?php

namespace App\CommandProcess\Admin\LeadDocument;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\LeadDocumentService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetLeadDocumentHandler implements Handler
{

    public LeadDocumentService $dbService;

    public function __construct(LeadDocumentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getById($command->documentId);
    }
}
