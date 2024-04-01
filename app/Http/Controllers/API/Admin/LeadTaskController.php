<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\LeadAppointment\DeleteLeadAppointment;
use App\CommandProcess\Admin\LeadAppointment\GetFilteredLeadAppointments;
use App\CommandProcess\Admin\LeadAppointment\GetLeadAppointment;
use App\CommandProcess\Admin\LeadAppointment\StoreLeadAppointment;
use App\CommandProcess\Admin\LeadAppointment\UpdateLeadAppointment;
use App\CommandProcess\Admin\LeadTask\DeleteLeadTask;
use App\CommandProcess\Admin\LeadTask\GetFilteredLeadTasks;
use App\CommandProcess\Admin\LeadTask\GetLeadTask;
use App\CommandProcess\Admin\LeadTask\StoreLeadTask;
use App\CommandProcess\Admin\LeadTask\UpdateLeadTask;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeadTask\CreateLeadTaskRequest;
use App\Http\Requests\Admin\LeadTask\DeleteLeadTaskRequest;
use App\Http\Requests\Admin\LeadTask\UpdateLeadTaskRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class LeadTaskController extends Controller
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
        $tasks = $this->commandBus->execute(new GetFilteredLeadTasks((int) $request->get('lead_id')));

        return $this->respondWithSuccess(trans('Lead task fetched successfully'), $tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateLeadTaskRequest $request
     * @return JsonResponse
     */
    public function store(CreateLeadTaskRequest $request): JsonResponse
    {
        $task = $this->commandBus->execute( new StoreLeadTask($request->all()) );

        return $this->respondCreated(__('Lead task created successfully'), $task);
    }

    /**
     * Display the specified resource.
     *
     * @param $taskId
     * @return JsonResponse
     */
    public function show($taskId)
    {
        $category = $this->commandBus->execute(new GetLeadTask((int) $taskId));

        return $this->respondWithContentOnly($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLeadTaskRequest $request
     * @return JsonResponse
     */
    public function update(UpdateLeadTaskRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateLeadTask((int) $request->get('id'), $request->all()));

        return $this->respondUpdated(__('Lead task updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteLeadTaskRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteLeadTaskRequest $request): JsonResponse
    {
        $this->commandBus->execute(new DeleteLeadTask((int) $request->get('task_id')));

        return $this->respondWithSuccess(__('Lead task deleted successfully'));
    }


}
