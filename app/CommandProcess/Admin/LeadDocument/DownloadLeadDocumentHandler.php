<?php

namespace App\CommandProcess\Admin\LeadDocument;

use App\Helpers\Config\BuchConfig;
use App\Services\Admin\LeadDocumentService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DownloadLeadDocumentHandler implements Handler
{
    private LeadDocumentService $leadDocumentService;

    public function __construct(LeadDocumentService $leadDocumentService)
    {
        $this->leadDocumentService = $leadDocumentService;
    }

    /**
     * @throws ValidationException
     */
    public function handle(Command $command)
    {
        $document = $this->leadDocumentService->getById($command->documentId);

        if (!$document) {
            throw ValidationException::withMessages(['document_id' => trans('Lead document not found')]);
        }

        $filePath = Storage::path( BuchConfig::getLeadDocumentRelativePath($document->lead_id.DIRECTORY_SEPARATOR.$document->path) );

        if (!File::exists($filePath)) {
            throw ValidationException::withMessages(['invoice_id' => trans('Invoice file not found')]);
        }

        return response()->download($filePath, $document->name);
    }
}
