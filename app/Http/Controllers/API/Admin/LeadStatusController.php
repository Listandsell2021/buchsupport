<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\LeadStatus\DeleteLeadStatus;
use App\CommandProcess\Admin\LeadStatus\GetFilteredLeadStatus;
use App\CommandProcess\Admin\LeadStatus\GetLeadStatus;
use App\CommandProcess\Admin\LeadStatus\SetDefaultLeadStatus;
use App\CommandProcess\Admin\LeadStatus\StoreLeadStatus;
use App\CommandProcess\Admin\LeadStatus\UpdateLeadStatus;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeadStatus\ChangeDefaultLeadStatusRequest;
use App\Http\Requests\Admin\LeadStatus\CreateLeadStatusRequest;
use App\Http\Requests\Admin\LeadStatus\DeleteLeadStatusRequest;
use App\Http\Requests\Admin\LeadStatus\UpdateLeadStatusRequest;
use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;


class LeadStatusController extends Controller
{
    use ApiResponseHelpers;

    protected CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Get Filtered Lead Status
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFilteredLeadStatus(Request $request): JsonResponse
    {
        $leadStatus = $this->commandBus->execute(new GetFilteredLeadStatus($request->all()));

        return $this->respondWithSuccess(__('Lead status fetched successfully'), $leadStatus);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateLeadStatusRequest $request
     * @return JsonResponse
     */
    public function store(CreateLeadStatusRequest $request): JsonResponse
    {
        $leadStatus = $this->commandBus->execute(new StoreLeadStatus($request->all()));

        return $this->respondWithSuccess(__('Lead status created successfully'), $leadStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param $leadStatusId
     * @return JsonResponse
     */
    public function show($leadStatusId): JsonResponse
    {
        $lead = $this->commandBus->execute(new GetLeadStatus((int) $leadStatusId));

        return $this->respondWithContentOnly($lead);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLeadStatusRequest $request
     * @return JsonResponse
     */
    public function update(UpdateLeadStatusRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateLeadStatus((int) $request->get('id'), $request->only(LeadStatus::fillableProps())));

        return $this->respondWithSuccess(__('Lead status updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteLeadStatusRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteLeadStatusRequest $request): JsonResponse
    {
        $this->commandBus->execute(new DeleteLeadStatus((int) $request->get('status_id')));

        return $this->respondWithSuccess(__('Lead status deleted successfully'));
    }


    /**
     * Change Active Status
     *
     * @param ChangeDefaultLeadStatusRequest $request
     * @return JsonResponse
     */
    public function setDefault(ChangeDefaultLeadStatusRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->commandBus->execute(
            new SetDefaultLeadStatus(
                (int) $request->get('status_id'),
                (int) $request->get('default')
            )
        );

        return $this->respondWithSuccess(__('Default lead status updated'));
    }

}
