<?php

namespace App\Services\Admin;


use App\Libraries\Settings\Setting;
use App\Models\LeadContract;
use App\Models\Order;
use App\Models\OrderStage;
use App\Models\ServicePipeline;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;


class OrderService
{

    public function searchAndPaginate($data)
    {
        $filters = $data['filters'] ?? [];

        return Order::with(['service', 'user', 'pipeline', 'lead'])
            ->where(function($query) use ($filters) {
                if (hasInput($filters['name'] ?? '')) {
                    $query->where('services.name', 'LIKE', '%' . $filters['name'] . '%');
                }
            })
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
        return Order::with(['service', 'user', 'pipeline', 'stages', 'stages.pipeline', 'lead', 'lead.salesperson'])->where('id', $orderId)->first();
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
            'user_id' => $data['user_id'],
            'service_id' => $data['service_id'],
            'pipeline_id' => $pipeline->id,
            'price' => $price,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'tax' => Setting::getVatPercentage(),
            'tax_price' => $total - $subtotal,
            'total' => $total,
            'note' => $data['note'],
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
     * @return void
     */
    public function update(int $orderId, array $data): void
    {
        Order::where('id', $orderId)->update(Arr::only($data, Order::fillableProps()));
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


}
