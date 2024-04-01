<?php

namespace App\Services\Admin;

use App\Models\Comment;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class CommentService
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

        return Comment::select('comments.*', DB::raw('CONCAT(users.first_name, " ",users.last_name) as name'))
            ->join('users', 'comments.user_id', 'users.id')
            ->where(function ($query) use ($filters) {
                if (isset($filters['name']) && strlen((string)$filters['name']) > 0) {
                    $query->where(
                        DB::raw("CONCAT_WS(' ', users.first_name, users.last_name)"), 'LIKE', '%' . $filters['name'] . '%'
                    );
                }
            })
            ->sorting(['users.first_name', 'comments.text', 'comments.approved'], 'comments.id', 'desc')
            ->paginate(getPerPageTotal());
    }


    /**
     * Get specific record by id.
     *
     * @param int $commentId
     * @return mixed
     */
    public function getById(int $commentId): mixed
    {
        return Comment::find($commentId);
    }


    /**
     * Update Approved Status
     *
     * @param int $commentId
     * @param int $status
     * @return void
     */
    public function updateApprovedStatus(int $commentId, int $status): void
    {
        Comment::where('id', $commentId)->update(['approved' => $status]);
    }

    /**
     * Update Bulk Approved Status
     *
     * @param array $commentIds
     * @param int $status
     * @return void
     */
    public function updateBulkApprovedStatus(array $commentIds, int $status): void
    {
        Comment::whereIn('id', $commentIds)->update(['approved' => $status]);
    }


    /**
     * Delete specific record.
     *
     * @param int $commentId
     * @return void
     */
    public function delete(int $commentId): void
    {
        Comment::where('id', $commentId)->delete();
    }


    /**
     * Delete specific record.
     *
     * @param array $commentIds
     * @return void
     */
    public function deleteBulk(array $commentIds): void
    {
        Comment::whereIn('id', $commentIds)->delete();
    }



}
