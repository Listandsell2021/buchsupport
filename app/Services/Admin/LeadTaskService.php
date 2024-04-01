<?php

namespace App\Services\Admin;

use App\Models\LeadTask;
use Illuminate\Support\Facades\DB;

class LeadTaskService
{

    /**
     * Search And Paginate
     *
     * @param int $leadId
     * @return mixed
     */
    public function searchAndPaginate(int $leadId): mixed
    {
        $filters = $data['filters'] ?? [];

        return LeadTask::select('lead_tasks.*',
            DB::raw('CONCAT(admins.first_name, " ", admins.last_name) as created_by')
        )
            ->leftJoin('admins', 'lead_tasks.admin_id', 'admins.id')
            ->where(function($query) use ($filters) {
                if (hasInput($filters['name'] ?? '')) {
                    $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
                }
            })
            ->where('lead_id', $leadId)
            ->paginate(6);
    }

    /**
     * Get specific record by id.
     *
     * @param int $taskId
     * @return mixed
     */
    public function getById(int $taskId): mixed
    {
        return LeadTask::find($taskId);
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        return LeadTask::create($data);
    }

    /**
     * Update specific record to database.
     *
     * @param int $taskId
     * @param array $data
     * @return void
     */
    public function update(int $taskId, array $data): void
    {
        LeadTask::where('id', $taskId)->update($data);
    }

    /**
     * Delete specific record.
     *
     * @param int $taskId
     * @return void
     */
    public function delete(int $taskId): void
    {
        LeadTask::where('id', $taskId)->delete();
    }


}
