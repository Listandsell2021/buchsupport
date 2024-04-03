<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\Service\GetAllServices;
use App\CommandProcess\Admin\ServicePipeline\ChangeDefaultServicePipeline;
use App\CommandProcess\Admin\ServicePipeline\DeleteServicePipeline;
use App\CommandProcess\Admin\ServicePipeline\GetFilteredServicePipelines;
use App\CommandProcess\Admin\ServicePipeline\GetServicePipeline;
use App\CommandProcess\Admin\ServicePipeline\StoreServicePipeline;
use App\CommandProcess\Admin\ServicePipeline\UpdateServicePipeline;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeadStatus\ChangeDefaultLeadStatusRequest;
use App\Http\Requests\Admin\Service\UpdateServiceRequest;
use App\Http\Requests\Admin\ServicePipeline\ChangeDefaultRequest;
use App\Http\Requests\Admin\ServicePipeline\CreateServicePipelineRequest;
use App\Http\Requests\Admin\ServicePipeline\UpdateServicePipelineRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;


class ServicePipelineController extends Controller
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
    public function index(Request $request, $serviceId): JsonResponse
    {
        $pipelines = $this->commandBus->execute(new GetFilteredServicePipelines((int) $serviceId, $request->all()));

        return $this->respondWithSuccess(trans('Service status fetched successfully'), $pipelines);
    }


    /**
     * Store a new resource
     *
     * @param CreateServicePipelineRequest $request
     * @return JsonResponse
     */
    public function store(CreateServicePipelineRequest $request): JsonResponse
    {
        $pipeline = $this->commandBus->execute(
            new StoreServicePipeline($request->all())
        );

        return $this->respondCreated(__('Service status created successfully'), $pipeline);
    }


    /**
     * Display specified resource.
     *
     * @param $pipelineId
     * @return JsonResponse
     */
    public function show($pipelineId): JsonResponse
    {
        $pipeline = $this->commandBus->execute(new GetServicePipeline((int) $pipelineId));

        return $this->respondWithContentOnly($pipeline);
    }


    /**
     * Update the specified resource
     *
     * @param UpdateServicePipelineRequest $request
     * @param $pipelineId
     * @return JsonResponse
     */
    public function update(UpdateServicePipelineRequest $request, $pipelineId): JsonResponse
    {
        $this->commandBus->execute(new UpdateServicePipeline((int) $request->get('id'), $request->all()));

        return $this->respondUpdated(__('Service status updated successfully'));
    }

    /**
     * Remove the specified resource
     *
     * @param $pipelineId
     * @return JsonResponse
     */
    public function destroy($pipelineId): JsonResponse
    {
        $this->commandBus->execute(new DeleteServicePipeline((int) $pipelineId));

        return $this->respondWithSuccess(__('Service Pipeline deleted successfully'));
    }


    /**
     * Remove the specified resource
     *
     * @param ChangeDefaultRequest $request
     * @return JsonResponse
     */
    public function changeDefault(ChangeDefaultRequest $request): JsonResponse
    {
        $this->commandBus->execute(new ChangeDefaultServicePipeline((int) $request->get('model_id'), (int) $request->get('is_active')));

        return $this->respondWithSuccess(__('Default changed successfully'));
    }


    /**
     * Get All Products
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllServices(Request $request): JsonResponse
    {
        $services = $this->commandBus->execute(new GetAllServices());

        return $this->respondWithSuccess(__('Services fetched successfully'), $services);
    }


    /**
     * Sort Product Images
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sortProductImages(Request $request): JsonResponse
    {
        $this->commandBus->execute(new SortProductImages((array) $request->get('image_ids')));

        return $this->respondWithSuccess(__('Images sorted successfully'));
    }

}
