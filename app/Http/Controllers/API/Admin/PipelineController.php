<?php

namespace App\Http\Controllers\API\Admin;



use App\CommandProcess\Admin\Pipeline\AddCustomerToPipeline;
use App\CommandProcess\Admin\Pipeline\GetAllPipelines;
use App\CommandProcess\Admin\Pipeline\GetPipelineList;
use App\CommandProcess\Admin\Pipeline\MoveToPipeline;
use App\CommandProcess\Admin\Pipeline\SortPipeline;
use App\CommandProcess\Admin\Pipeline\StorePipeline;
use App\CommandProcess\Admin\SmartList\DeleteSmartList;
use App\CommandProcess\Admin\SmartList\GetAdminSmartList;
use App\Http\Requests\Admin\Pipeline\AddCustomerToPipelineRequest;
use App\Http\Requests\Admin\Pipeline\CreatePipelineRequest;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pipeline\MoveToPipelineRequest;
use App\Http\Requests\Admin\Pipeline\SortPipelineRequest;
use App\Http\Requests\Admin\SmartList\DeleteSmartListRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\CommandBus;


class PipelineController extends Controller
{
    use ApiResponseHelpers;

    protected CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }


    /**
     * Display a listing
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $pipelines = $this->commandBus->execute(new GetPipelineList());

        return $this->respondWithSuccess(trans('Pipeline fetched successfully'), $pipelines);
    }


    /**
     * Display a listing
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function all(Request $request): JsonResponse
    {
        $pipelines = $this->commandBus->execute(new GetAllPipelines());

        return $this->respondWithSuccess(trans('Pipeline fetched successfully'), $pipelines);
    }



    /**
     * Store a new pipeline
     *
     * @param CreatePipelineRequest $request
     * @return JsonResponse
     */
    public function store(CreatePipelineRequest $request): JsonResponse
    {
        $pipeline = $this->commandBus->execute(new StorePipeline($request->get('name')));

        return $this->respondCreated(__('Pipeline created successfully'), $pipeline);
    }


    /**
     * Move users to pipeline
     *
     * @param MoveToPipelineRequest $request
     * @return JsonResponse
     */
    public function move(MoveToPipelineRequest $request): JsonResponse
    {
        $pipeline = $this->commandBus->execute(new MoveToPipeline((int) $request->get('pipeline_id'), (array) $request->get('user_ids')));

        return $this->respondCreated(__('Pipeline entity moved successfully'), $pipeline);
    }


    /**
     * Sort pipeline
     *
     * @param SortPipelineRequest $request
     * @return JsonResponse
     */
    public function sort(SortPipelineRequest $request): JsonResponse
    {
        $pipeline = $this->commandBus->execute(new SortPipeline((int) $request->get('pipeline_id'), (array) $request->get('user_ids')));

        return $this->respondCreated(__('Pipeline entity sorted successfully'), $pipeline);
    }


    /**
     * Add customer to pipeline
     *
     * @param AddCustomerToPipelineRequest $request
     * @return JsonResponse
     */
    public function addCustomer(AddCustomerToPipelineRequest $request): JsonResponse
    {
        $pipeline = $this->commandBus->execute(new AddCustomerToPipeline((int) $request->get('pipeline_id'), (int) $request->get('user_id')));

        return $this->respondWithSuccess(__('Customer added to pipeline successfully'), $pipeline);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteSmartListRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteSmartListRequest $request): JsonResponse
    {
        $this->commandBus->execute( new DeleteSmartList((int) $request->get('smart_list_id')) );

        return $this->respondWithSuccess(__('Smart list deleted successfully'));
    }


    
}
