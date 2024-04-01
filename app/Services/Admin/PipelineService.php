<?php

namespace App\Services\Admin;

use App\Models\Pipeline;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PipelineService
{

    /**
     *  Get Pipeline with users
     *
     * @return Collection
     */
    public function getList(): Collection
    {
        return Pipeline::with(['users' => function ($query) {
            $query->select('users.id', 'users.first_name', 'users.last_name');
        }])->get();
    }


    /**
     *  Get All Pipelines
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Pipeline::all();
    }


    /**
     * Get specific record by id.
     *
     * @param int $pipelineId
     * @return mixed
     */
    public function getById(int $pipelineId): mixed
    {
        return Pipeline::find($pipelineId);
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        return Pipeline::create(Arr::only($data, Pipeline::fillableProps()));
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
        Pipeline::where('id', $pipelineId)->update($data);
    }

    /**
     * Delete specific record.
     *
     * @param int $pipelineId
     * @return void
     */
    public function delete(int $pipelineId): void
    {
        Pipeline::where('id', $pipelineId)->delete();
    }

    /**
     * Move to Pipeline
     *
     * @param int $pipelineId
     * @param array $userIds
     * @return void
     */
    public function moveToPipeline(int $pipelineId, array $userIds): void
    {
        DB::table('pipeline_users')->where('pipeline_id', $pipelineId)->delete();
        $data = [];
        $i = 1;
        foreach ($userIds as $userId) {
            $data[] = ['pipeline_id' => $pipelineId, 'user_id' => $userId, 'order_no' => $i++];
        }
        if (count($data)) {
            DB::table('pipeline_users')->insert($data);
        }
    }


    /**
     * Sort Pipeline
     *
     * @param int $pipelineId
     * @param array $userIds
     * @return void
     */
    public function sort(int $pipelineId, array $userIds): void
    {
        DB::table('pipeline_users')->where('pipeline_id', $pipelineId)->delete();
        $data = [];
        $i = 1;
        foreach ($userIds as $userId) {
            $data[] = ['pipeline_id' => $pipelineId, 'user_id' => $userId, 'order_no' => $i++];
        }
        if (count($data)) {
            DB::table('pipeline_users')->insert($data);
        }
    }


    /**
     * Add Customer to Pipeline
     *
     * @param int $pipelineId
     * @param int $userId
     * @return void
     */
    public function addCustomerToPipeline(int $pipelineId, int $userId): void
    {
        $orderNo = (int) DB::table('pipeline_users')->where('pipeline_id', $pipelineId)->max('order_no');

        DB::table('pipeline_users')->insert([
            'pipeline_id' => $pipelineId,
            'user_id' => $userId,
            'order_no' => ++$orderNo
        ]);
    }


}
