<?php

namespace App\Services\Admin;


use App\DataHolders\Enum\ServicePipelineStatus;
use App\Libraries\Settings\Setting;
use App\Models\Lead;
use App\Models\LeadContract;
use App\Models\Order;
use App\Models\OrderStage;
use App\Models\ServicePipeline;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class OrderService
{

    public function searchAndPaginate($data)
    {
        $filters = $data['filters'] ?? [];

        $priceFrom = $filters['price_from'] ?? '';
        $priceTo = $filters['price_to'] ?? '';
        return Order::select('orders.*')
            ->with(['service', 'user', 'pipeline', 'lead'])
            ->where(function($query) use ($filters, $priceFrom, $priceTo) {
                if (hasInput($filters['order_id'] ?? '')) {
                    $query->where('orders.id', 'LIKE', '%' . $filters['order_id'] . '%');
                }
                if (hasInput($filters['user_name'] ?? '')) {
                    $query->where(DB::raw('(SELECT CONCAT_WS(" ", first_name, last_name) FROM users WHERE users.id = orders.user_id)'), 'LIKE', '%' . $filters['user_name'] . '%');
                }
                if (hasArrayInput($filters['service_ids'] ?? [])) {
                    $query->whereIn('orders.service_id', $filters['service_ids']);
                }
                if (hasInput($priceFrom) || hasInput($priceTo)) {
                    if ($priceFrom) {
                        $query->where('orders.total', '>=', $priceFrom);
                    }
                    if ($priceTo) {
                        $query->where('orders.total', '<=', $priceTo);
                    }
                }
                if (hasInput($filters['date_from'] ?? '') && isDate($filters['date_from'])) {
                    $query->where(DB::raw('DATE(orders.order_at)'), '>=', getGlobalDate($filters['date_from']));
                }
                if (hasInput($filters['date_to'] ?? '') && isDate($filters['date_to'])) {
                    $query->where(DB::raw('DATE(orders.order_at)'), '<=', getGlobalDate($filters['date_to']));
                }
            })
            ->orderBy('order_at', 'desc')
            ->paginate(getPerPageTotal());
    }


    /**
     * Get specific record by id.
     *
     * @param int $orderId
     * @return mixed
     */
    public function getById(int $orderId): mixed
    {
        return Order::with(['service', 'user', 'pipeline', 'stages', 'stages.pipeline', 'lead', 'admin'])->where('id', $orderId)->first();
    }


    /**
     * Get next stage by order
     *
     * @param int $orderId
     * @return mixed
     */
    public function getNextPipelineByOrderId(int $orderId): mixed
    {
        $order = Order::find($orderId);
        $completedStages = OrderStage::where('order_id', $orderId)->get();

        return ServicePipeline::where('service_id', $order->service_id)->whereNotIn('id', $completedStages->pluck('pipeline_id')->toArray())->orderBy('order_no')->first();
    }


    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        $pipeline = ServicePipeline::where('service_id', $data['service_id'])->orderBy('default', 'desc')->first();

        $price = (float) $data['price'];
        $quantity = (int) $data['quantity'];
        $total = $price * $quantity;
        $tax = Setting::getVatPercentage();
        $subtotal = ($total * 100 / (100 + $tax));

        $order = Order::create([
            'admin_id' => $data['admin_id'] ?? null,
            'user_id' => $data['user_id'],
            'service_id' => $data['service_id'],
            'pipeline_id' => $pipeline->id,
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'tax' => Setting::getVatPercentage(),
            'tax_price' => $total - $subtotal,
            'total' => $total,
            'note' => (string) $data['note'],
            'order_at' => getCurrentDateTime(),
            'order_no' => 1,
        ]);

        $this->updateOrderStage((int) $order->id, (int) $pipeline->id);

        return $order;
    }

    /**
     * Update Order Stage
     *
     * @param int $orderId
     * @param int $pipelineId
     * @return mixed
     */
    public function updateOrderStage(int $orderId, int $pipelineId): mixed
    {
        return OrderStage::create([
            'order_id' => $orderId,
            'pipeline_id' => $pipelineId,
            'created_at' => getCurrentDateTime(),
        ]);
    }


    /**
     * Update specific record to database.
     *
     * @param int $orderId
     * @param array $data
     * @return mixed
     */
    public function update(int $orderId, array $data): mixed
    {
        $order = Order::find($orderId);
        $hasNewService = false;
        $pipeline = ServicePipeline::where('service_id', $data['service_id'])->orderBy('default', 'desc')->first();
        if ($order->service_id != $data['service_id']) {
            OrderStage::where('order_id', $orderId)->delete();
            $hasNewService = true;
        }

        $price = (float) $data['price'];
        $quantity = (int) $data['quantity'];
        $total = $price * $quantity;
        $tax = Setting::getVatPercentage();
        $subtotal = ($total * 100 / (100 + $tax));

        Order::where('id', $orderId)->update([
            'admin_id' => $data['admin_id'] ?? null,
            'user_id' => $data['user_id'],
            'service_id' => $data['service_id'],
            'pipeline_id' => $hasNewService ? $pipeline->id : $order->pipeline_id,
            'status' => $hasNewService ? null : $order->status,
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'tax' => Setting::getVatPercentage(),
            'tax_price' => $total - $subtotal,
            'total' => $total,
            'note' => (string) $data['note'],
            'order_at' => getCurrentDateTime(),
            'order_no' => 1,
        ]);

        if ($hasNewService) {
            $this->updateOrderStage((int) $order->id, (int) $pipeline->id);
        }

        return $order;
    }

    /**
     * Delete specific record.
     *
     * @param int $orderId
     * @return void
     */
    public function delete(int $orderId): void
    {
        Order::where('id', $orderId)->delete();
    }


    /**
     * Delete bulk record
     *
     * @param array $orderIds
     * @return void
     */
    public function deleteBulk(array $orderIds): void
    {
        Order::whereIn('id', $orderIds)->delete();
    }


    /**
     * Get All Products
     *
     * @return Collection
     */
    public function getAllServices(): Collection
    {
        return Order::active()->get();
    }

    /**
     * Update Order Pipeline
     *
     * @param int $orderId
     * @param int $pipelineId
     * @param int $orderNo
     * @return bool
     */
    public function updatePipeline(int $orderId, int $pipelineId, int $orderNo): bool
    {
        return (bool) Order::where('id', $orderId)->update([
            'pipeline_id' => $pipelineId,
            'order_no' => $orderNo
        ]);
    }


    /**
     * Update incremental order
     *
     * @param array $orderIds
     * @return void
     */
    public function sortIncrementalOrders(array $orderIds): void
    {
        $i = 1;
        foreach ($orderIds as $orderId) {
            Order::where('id', $orderId)->update(['order_no' => $i++]);
        }
    }

    public function updateOrderShipment(int $orderId, string $shipmentNo)
    {
        return Order::where('id', $orderId)->update(['shipment_no' => $shipmentNo]);
    }

    /**
     * Update Order Status
     *
     * @param int $orderId
     * @param int $pipelineId
     * @param string $status
     * @return void
     */
    public function updateOrderStatus(int $orderId, int $pipelineId, string $status): void
    {
        $order = Order::find($orderId);
        $order->pipeline_id = $pipelineId;
        $order->status = $status;
        $order->save();

        $this->updateOrderStage($orderId, $pipelineId);

        if ($order->lead_id) {
            Lead::where('id', $order->lead_id)->update(['main_status' => $status]);
        }
    }


}
