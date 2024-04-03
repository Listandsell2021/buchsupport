<?php

namespace App\Services\Admin;

use App\Models\ServicePipeline;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ServicePipelineService
{

    public function searchAndPaginate($data)
    {
        $filters = $data['filters'] ?? [];

        return ServicePipeline::where(function($query) use ($filters) {
            if (hasInput($filters['name'] ?? '')) {
                $query->where('service_pipelines.name', 'LIKE', '%' . $filters['name'] . '%');
            }
        })
            ->sorting(['service_pipelines.name'], 'service_pipelines.id')
            ->paginate(getPerPageTotal());
    }


    /**
     * Get specific record by id.
     *
     * @param int $pipelineId
     * @return mixed
     */
    public function getById(int $pipelineId): mixed
    {
        return ServicePipeline::find($pipelineId);
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        $orderNo = (int) ServicePipeline::max('order_no');

        return ServicePipeline::create([
            'service_id'    => (int) $data['service_id'],
            'name'          => $data['name'],
            'default'       => (int) $data['default'],
            'has_tracking'  => (int) $data['has_tracking'],
            'order_no'      => ++$orderNo,
        ]);
    }

    /**
     * Update specific record to database.
     *
     * @param int $pipelineId
     * @param array $data
     * @return void
     */
    public function update(int $pipelineId, array $data): void
    {
        $default = (int) $data['default'];

        ServicePipeline::where('id', $pipelineId)->update([
            'name'          => $data['name'],
            'default'       => $default,
            'has_tracking'  => (int) $data['has_tracking'],
        ]);

        if ($default) {
            ServicePipeline::where('id', '!=', $pipelineId)->update(['default' => 0]);
        }
    }

    /**
     * Delete specific record.
     *
     * @param int $pipelineId
     * @return void
     */
    public function delete(int $pipelineId): void
    {
        ServicePipeline::where('id', $pipelineId)->delete();
    }


    /**
     * Delete bulk record
     *
     * @param array $pipelineIds
     * @return void
     */
    public function deleteBulk(array $pipelineIds): void
    {
        ServicePipeline::whereIn('id', $pipelineIds)->delete();
    }


    /**
     * Get All Products
     *
     * @return Collection
     */
    public function getAllServices(): Collection
    {
        return ServicePipeline::active()->get();
    }

    /**
     * Change Default Pipeline
     *
     * @param int $pipelineId
     * @param int $default
     * @return void
     */
    public function changeDefault(int $pipelineId, int $default): void
    {
        ServicePipeline::where('id', $pipelineId)->update(['default' => $default]);

        if ($default) {
            ServicePipeline::where('id', '!=', $pipelineId)->update(['default' => 0]);
        }
    }


}
