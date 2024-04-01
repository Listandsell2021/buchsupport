<?php

namespace App\Services\Admin;

use App\Models\CallUser;
use Illuminate\Support\Facades\DB;

class UserInquiryService
{

    /**
     * Search And Paginate
     *
     * @param array $data
     * @return mixed
     */
    public function searchAndPaginate(array $data): mixed
    {
        $filters = $data['filters'] ?? [];

        return CallUser::with('user')
            ->where(function ($query) use ($filters) {
                if (isset($filters['name']) && strlen((string)$filters['name']) > 0) {
                    $query->where(
                        DB::raw("CONCAT_WS(' ', call_users.first_name, call_users.last_name)"), 'LIKE', '%' . $filters['name'] . '%'
                    );
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(getPerPageTotal());
    }


    /**
     * Get specific record by id.
     *
     * @param int $inquiryId
     * @return mixed
     */
    public function getById(int $inquiryId): mixed
    {
        return CallUser::find($inquiryId);
    }


    /**
     * Update Approved Status
     *
     * @param int $inquiryId
     * @param int $status
     * @return void
     */
    public function updateApprovedStatus(int $inquiryId, int $status): void
    {
        CallUser::where('id', $inquiryId)->update(['approved' => $status]);
    }

    /**
     * Update Bulk Approved Status
     *
     * @param array $inquiryIds
     * @param int $status
     * @return void
     */
    public function updateBulkApprovedStatus(array $inquiryIds, int $status): void
    {
        CallUser::whereIn('id', $inquiryIds)->update(['approved' => $status]);
    }


    /**
     * Delete specific record.
     *
     * @param int $inquiryId
     * @return void
     */
    public function delete(int $inquiryId): void
    {
        CallUser::where('id', $inquiryId)->delete();
    }


    /**
     * Delete specific record.
     *
     * @param array $inquiryIds
     * @return void
     */
    public function deleteBulk(array $inquiryIds): void
    {
        CallUser::whereIn('id', $inquiryIds)->delete();
    }



}
