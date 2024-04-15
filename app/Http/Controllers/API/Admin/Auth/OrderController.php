<?php

namespace App\Http\Controllers\API\Admin\Auth;


use App\CommandProcess\Admin\Lead\DownloadContractDocument;
use App\CommandProcess\Admin\Order\CreateLeadCustomer;
use App\CommandProcess\Admin\Order\DownloadOrderContractDocument;
use App\CommandProcess\Admin\Order\GetFilteredOrders;
use App\CommandProcess\Admin\Order\SortOrders;
use App\CommandProcess\Admin\Order\UpdateNextOrderStage;
use App\CommandProcess\Admin\Order\UpdateOrder;
use App\CommandProcess\Admin\Order\UpdateOrderPipeline;
use App\CommandProcess\Admin\Order\UpdateOrderShipment;
use App\CommandProcess\Admin\Order\UpdateOrderToLastPipeline;
use App\CommandProcess\Admin\Service\GetAllServices;
use App\CommandProcess\Admin\Order\GetOrder;
use App\CommandProcess\Admin\Order\StoreOrder;
use App\CommandProcess\Admin\Service\DeleteService;
use App\CommandProcess\Admin\Service\UpdateService;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\DownloadContractDocumentRequest;
use App\Http\Requests\Admin\Order\ChangeOrderPipelineRequest;
use App\Http\Requests\Admin\Order\CreateLeadCustomerRequest;
use App\Http\Requests\Admin\Order\CreateOrderRequest;
use App\Http\Requests\Admin\Order\DownloadOrderContractDocumentRequest;
use App\Http\Requests\Admin\Order\UpdateOrderRequest;
use App\Http\Requests\Admin\Order\UpdateOrderShipmentRequest;
use App\Http\Requests\Admin\Order\UpdateOrderToLastPipelineRequest;
use App\Models\ServicePipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\CommandBus;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


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
        $order = $this->commandBus->execute(new StoreOrder($request->all()));

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
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request): JsonResponse
    {
        $this->commandBus->execute(new UpdateOrder((int) $request->get('order_id'), $request->all()));

        return $this->respondUpdated(__('Order updated successfully'));
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
     * @param ChangeOrderPipelineRequest $request
     * @return JsonResponse
     */
    public function changePipeline(ChangeOrderPipelineRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateOrderPipeline(
                (int) $request->get('order_id'),
                (int) $request->get('pipeline_id'),
                (int) $request->get('order_no')
            )
        );

        return $this->respondWithSuccess(__('Order status changed successfully'));
    }

    /**
     * Sort Orders
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
     * Move to last pipeline
     *
     * @param UpdateOrderToLastPipelineRequest $request
     * @return JsonResponse
     */
    public function addToLastPipeline(UpdateOrderToLastPipelineRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateOrderToLastPipeline(
                (int) $request->get('order_id'),
                $request->get('pipeline_id'),
                $request->get('status')
            )
        );

        return $this->respondWithSuccess(__('Order updated successfully'));
    }


    /**
     * Get Service Pipeline In Kanban
     *
     * @param Request $request
     * @param $serviceId
     * @return JsonResponse
     */
    public function getOrderPipelineInKanban(Request $request, $serviceId): JsonResponse
    {
        $pipelines = ServicePipeline::with(['orders' => function ($query) {
            $query->with(['user', 'stages', 'lead'])->where('status', null);
        }, ]) //'orders.user', 'orders.stages', 'orders.lead'
            ->where('service_id', $serviceId)->orderBy('order_no')
            ->get();

        return $this->respondWithContentOnly($pipelines);
    }


    /**
     * Get Contract Detail
     *
     * @param DownloadOrderContractDocumentRequest $request
     * @return BinaryFileResponse
     */
    public function downloadContractDocument(DownloadOrderContractDocumentRequest $request): BinaryFileResponse
    {
        return $this->commandBus->execute(new DownloadOrderContractDocument((int) $request->get('order_id')));
    }


    /**
     * Get Service Pipeline In Kanban
     *
     * @param CreateLeadCustomerRequest $request
     * @return JsonResponse
     */
    public function createCustomerFromLead(CreateLeadCustomerRequest $request): JsonResponse
    {
        $this->commandBus->execute(new CreateLeadCustomer($request->all()));

        return $this->respondWithSuccess(__('Customer created successfully'));
    }


    /**
     * Get Service Pipeline In Kanban
     *
     * @param UpdateOrderShipmentRequest $request
     * @return JsonResponse
     */
    public function updateOrderShipment(UpdateOrderShipmentRequest $request): JsonResponse
    {
        $this->commandBus->execute(
            new UpdateOrderShipment((int) $request->get('order_id'), (string) $request->get('shipment_no'))
        );

        return $this->respondWithSuccess(__('Customer created successfully'));
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
