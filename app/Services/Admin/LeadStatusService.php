<?php

namespace App\Services\Admin;

use App\Models\LeadStatus;
use Illuminate\Support\Arr;

class LeadStatusService
{

    /**
     * Search And Paginate
     *
     * @param array $filters
     * @return mixed
     */
    public function searchAndPaginate(array $filters): mixed
    {
        return LeadStatus::where(function($query) use ($filters) {
                if (hasInput($filters['name'] ?? '')) {
                    $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
                }
                if (hasInput($filters['code'] ?? '')) {
                    $query->where('code', 'LIKE', '%' . $filters['code'] . '%');
                }
                if (hasInput($filters['default'] ?? '')) {
                    $query->where('default', (int) $filters['default']);
                }
            })
            ->paginate(6);
    }

    /**
     * Get specific record by id.
     *
     * @param int $statusId
     * @return mixed
     */
    public function getById(int $statusId): mixed
    {
        return LeadStatus::find($statusId);
    }

    /**
     * Get Incremental Order No
     *
     * @return int
     */
    public function getIncrementalOrderNo(): int
    {
        $max = (int) LeadStatus::max('order_no');
        return ++$max;
    }
    
    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        $leadStatus = LeadStatus::create(Arr::only($data, LeadStatus::fillableProps()));

        if ($leadStatus->default) {
            LeadStatus::where('id', '!=', $leadStatus->id)->update(['default' => 0]);
        }

        return $leadStatus;
    }

    /**
     * Update specific record to database.
     *
     * @param int $statusId
     * @param array $data
     * @return void
     */
    public function update(int $statusId, array $data)
    {
        LeadStatus::where('id', $statusId)->update($data);

        if (isset($data['default']) && $data['default']) {
            LeadStatus::where('id', '!=', $statusId)->update(['default' => 0]);
        }
    }

    /**
     * Delete specific record.
     *
     * @param int $statusId
     * @return void
     */
    public function delete(int $statusId)
    {
        LeadStatus::where('id', $statusId)->delete();
    }


    /**
     * Set Default
     *
     * @param int $statusId
     * @param int $default
     * @return void
     */
    public function setDefault(int $statusId, int $default): void
    {
        LeadStatus::where('id', $statusId)->update(['default' => $default]);

        if ($default) {
            LeadStatus::where('id', '!=', $statusId)->update(['default' => 0]);
        }
    }



}
