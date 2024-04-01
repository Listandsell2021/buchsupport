<?php

namespace App\CommandProcess\Admin\Lead;

use App\Http\Resources\Admin\LeadNote\LeadNoteResource;
use App\Services\Admin\LeadService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetLeadNotesHandler implements Handler
{
    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $leadNotes = $this->leadService->getLeadNotes($command->leadId);

        return LeadNoteResource::collection($leadNotes);
    }
}
