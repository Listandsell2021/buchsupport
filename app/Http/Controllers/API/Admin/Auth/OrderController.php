<?php

namespace App\Http\Controllers\API\Admin\Auth;


use App\CommandProcess\Admin\Order\GetFilteredOrders;
use App\CommandProcess\Admin\Order\SortOrders;
use App\CommandProcess\Admin\Order\UpdateIncrementalOrder;
use App\CommandProcess\Admin\Order\UpdateOrderPipeline;
use App\CommandProcess\Admin\Service\GetAllServices;
use App\CommandProcess\Admin\Order\GetOrder;
use App\CommandProcess\Admin\Order\StoreOrder;
use App\CommandProcess\Admin\Service\DeleteService;
use App\CommandProcess\Admin\Service\UpdateService;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\CreateOrderRequest;
use App\Http\Requests\Admin\Order\UpdateOrderRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;


class OrderController extends Controller
{
    use ApiResponseHelpers;

    protected CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }


    /**
     * Display resources
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $orders = $this->commandBus->execute(new GetFilteredOrders($request->all()));

        return $this->respondWithSuccess(trans('Orders fetched successfully'), $orders);
    }


    /**
     * Store a new resource
     *
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $order = $this->commandBus->execute(
            new StoreOrder($request->all())
        );

        return $this->respondCreated(__('Order created successfully'), $order);
    }


    /**
     * Get resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $order = $this->commandBus->execute(new GetOrder((int) $request->get('id')));

        if (!$order) {
            return $this->respondError();
        }

        return $this->respondWithContentOnly($order);
    }


    /**
     * Update specified resource
     *
     * @param UpdateOrderRequest $request
     * @param $orderId
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, $orderId): JsonResponse
    {
        $this->commandBus->execute(new UpdateService((int) $request->get('id'), $request->all()));

        return $this->respondUpdated(__('Service updated successfully'));
    }


    /**
     * Remove specified resource
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $this->commandBus->execute(new DeleteService((int) $request->get('order_id')));

        return $this->respondWithSuccess(__('Order deleted successfully'));
    }


    /**
     * Remove specified resource
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changePipeline(Request $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateOrderPipeline(
                (int) $request->get('order_id'),
                (int) $request->get('pipeline_id'),
                (int) $request->get('order_no')
            )
        );

        return $this->respondWithSuccess(__('Order deleted successfully'));
    }

    /**
     * Remove specified resource
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sortOrders(Request $request): JsonResponse
    {
        $this->commandBus->execute(
            new SortOrders((array) $request->get('order_ids'))
        );

        return $this->respondWithSuccess(__('Order sorted successfully'));
    }



    /**
     * Get All Orders
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllServices(Request $request): JsonResponse
    {
        $orders = $this->commandBus->execute(new GetAllServices());

        return $this->respondWithSuccess(__('Orders fetched successfully'), $orders);
    }

    

}
