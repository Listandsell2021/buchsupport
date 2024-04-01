<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\Lead\DownloadContractDocument;
use App\CommandProcess\Admin\LeadDocument\DeleteLeadDocument;
use App\CommandProcess\Admin\LeadDocument\DownloadLeadDocument;
use App\CommandProcess\Admin\LeadDocument\GetFilteredLeadDocuments;
use App\CommandProcess\Admin\LeadDocument\StoreLeadDocument;
use App\CommandProcess\Admin\LeadTask\GetLeadTask;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeadDocument\CreateLeadDocumentRequest;
use App\Http\Requests\Admin\LeadDocument\DeleteLeadDocumentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class LeadDocumentController extends Controller
{
    use ApiResponseHelpers;

    protected CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listAll(Request $request): JsonResponse
    {
        $documents = $this->commandBus->execute(new GetFilteredLeadDocuments((int) $request->get('lead_id')));

        return $this->respondWithSuccess(trans('Lead documents fetched successfully'), $documents);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateLeadDocumentRequest $request
     * @return JsonResponse
     */
    public function store(CreateLeadDocumentRequest $request): JsonResponse
    {
        $task = $this->commandBus->execute(
            new StoreLeadDocument((int) $request->get('lead_id'), $request->file('document'))
        );

        return $this->respondCreated(__('Lead document created successfully'), $task);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteLeadDocumentRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteLeadDocumentRequest $request): JsonResponse
    {
        $this->commandBus->execute(new DeleteLeadDocument((int) $request->get('document_id')));

        return $this->respondWithSuccess(__('Lead document deleted successfully'));
    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return mixed
     */
    public function downloadDocument(Request $request): mixed
    {
        return $this->commandBus->execute(new DownloadLeadDocument((int) $request->get('document_id')));
    }

}
