<?php

namespace App\CommandProcess\Admin\LeadDocument;


use App\Helpers\Config\BuchConfig;
use App\Http\Resources\Admin\AdminResource;
use App\Models\LeadDocument;
use App\Services\Admin\LeadDocumentService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreLeadDocumentHandler implements Handler
{

    private LeadDocumentService $dbService;

    public function __construct(LeadDocumentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->saveLeadDocument($command->leadId, $command->document);

        $command->data['lead_id'] = $command->leadId;
        $command->data['admin_id'] = getAdminId();
        $command->data['name'] = $command->document->getClientOriginalName();
        $command->data['path'] = $command->document->getClientOriginalName();
        $command->data['size'] = intval($command->document->getSize()/1024);
        $command->data['pdf'] = $command->document->getClientOriginalExtension();

        return $this->dbService->save(Arr::only($command->data, LeadDocument::fillableProps()));
    }

    protected function saveLeadDocument(int $leadId, UploadedFile $document): void
    {
        Storage::disk('local')->putFileAs(BuchConfig::getLeadDocumentRelativePath($leadId), $document, $document->getClientOriginalName());
    }
}
