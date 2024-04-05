<?php

namespace App\Services\Admin;


use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;


class OrderService
{

    public function searchAndPaginate($data)
    {
        $filters = $data['filters'] ?? [];

        return Order::with(['service', 'user', 'pipeline'])
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
        return Order::with(['service', 'user', 'pipeline'])->where('id', $orderId)->first();
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        $savingData = Arr::only($data, Order::fillableProps());
        return Order::create(array_merge($savingData, ['order_at' => now()->toDateTime()]));
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
