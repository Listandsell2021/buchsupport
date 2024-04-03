<?php

namespace App\Http\Controllers\API\Admin;


use App\CommandProcess\Admin\Service\DeleteService;
use App\CommandProcess\Admin\Service\GetAllServices;
use App\CommandProcess\Admin\Service\GetFilteredServices;
use App\CommandProcess\Admin\Service\GetService;
use App\CommandProcess\Admin\Service\StoreService;
use App\CommandProcess\Admin\Service\UpdateService;
use App\CommandProcess\Admin\Service\UpdateServiceActiveStatus;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Administrator\ChangeActiveStatusRequest;
use App\Http\Requests\Admin\Service\AddProductImageRequest;
use App\Http\Requests\Admin\Service\CreateServiceRequest;
use App\Http\Requests\Admin\Service\RemoveProductImageRequest;
use App\Http\Requests\Admin\Service\UpdateServiceRequest;
use App\Http\Requests\Admin\Service\UpdateProductsBulkActionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\CommandBus;


class ServiceController extends Controller
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
    public function index(Request $request): JsonResponse
    {
        $services = $this->commandBus->execute(new GetFilteredServices($request->all()));

        return $this->respondWithSuccess(trans('Products fetched successfully'), $services);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateServiceRequest $request
     * @return JsonResponse
     */
    public function store(CreateServiceRequest $request): JsonResponse
    {
        $service = $this->commandBus->execute(
            new StoreService($request->all())
        );

        return $this->respondCreated(__('Service created successfully'), $service);
    }

    /**
     * Display the specified resource.
     *
     * @param $serviceId
     * @return JsonResponse
     */
    public function show($serviceId): JsonResponse
    {
        $service = $this->commandBus->execute(new GetService((int) $serviceId));

        return $this->respondWithContentOnly($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateServiceRequest $request
     * @param $serviceId
     * @return JsonResponse
     */
    public function update(UpdateServiceRequest $request, $serviceId): JsonResponse
    {
        $this->commandBus->execute(new UpdateService((int) $request->get('id'), $request->all()));

        return $this->respondUpdated(__('Service updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $serviceId
     * @return JsonResponse
     */
    public function destroy($serviceId): JsonResponse
    {
        $this->commandBus->execute(new DeleteService((int) $serviceId));

        return $this->respondWithSuccess(__('Product deleted successfully'));
    }


    /**
     * Change Active Status
     *
     * @param ChangeActiveStatusRequest $request
     * @return JsonResponse
     */
    public function changeActiveStatus(ChangeActiveStatusRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateServiceActiveStatus(
                (int) $request->get('model_id'),
                (int) $request->get('is_active')
            )
        );

        return $this->respondWithSuccess(__('Admin Active Status Updated'));
    }


    /**
     * Update Bulk Action
     *
     * @param UpdateProductsBulkActionRequest $request
     * @return JsonResponse
     */
    public function updateBulkAction(UpdateProductsBulkActionRequest $request): JsonResponse
    {
        $message = $this->commandBus->execute(
            new UpdateProductsBulkAction(
                (array) $request->get('data_ids'),
                (string) $request->get('action')
            )
        );

        return $this->respondWithSuccess($message);
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
     * Add Product Image
     *
     * @param AddProductImageRequest $request
     * @return JsonResponse
     */
    public function addProductImage(AddProductImageRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new AddProductImage((int) $request->get('product_id'), $request->file('image'))
        );

        return $this->respondWithSuccess(__('Image added successfully'));
    }


    /**
     * Add Product Image
     *
     * @param RemoveProductImageRequest $request
     * @return JsonResponse
     */
    public function removeProductImage(RemoveProductImageRequest $request): JsonResponse
    {
        $this->commandBus->execute(new DeleteProductImage((int) $request->get('image_id')));

        return $this->respondWithSuccess(__('Image removed successfully'));
    }


    /**
     * Get Product Images
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProductImages(Request $request): JsonResponse
    {
        $images = $this->commandBus->execute(new GetProductImages((int) $request->get('product_id')));

        return $this->respondWithSuccess(__('Product images fetched successfully'), $images);
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
