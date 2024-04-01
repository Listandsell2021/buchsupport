<?php

namespace App\Services\Admin;

use App\Models\LeadDocument;
use Illuminate\Support\Facades\DB;


class LeadDocumentService
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

        return LeadDocument::select('lead_documents.*',
            DB::raw('CONCAT(admins.first_name, " ", admins.last_name) as created_by')
        )
            ->leftJoin('admins', 'lead_documents.admin_id', 'admins.id')
            ->where(function($query) use ($filters) {
                if (hasInput($filters['name'] ?? '')) {
                    $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
                }
            })
            ->where('lead_documents.lead_id', $leadId)
            ->paginate(6);
    }

    /**
     * Get specific record by id.
     *
     * @param int $documentId
     * @return mixed
     */
    public function getById(int $documentId): mixed
    {
        return LeadDocument::find($documentId);
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        return LeadDocument::create($data);
    }

    /**
     * Delete specific record.
     *
     * @param int $documentId
     * @return void
     */
    public function delete(int $documentId): void
    {
        LeadDocument::where('id', $documentId)->delete();
    }


}
