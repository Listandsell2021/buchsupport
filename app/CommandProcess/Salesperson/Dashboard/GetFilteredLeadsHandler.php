<?php

namespace App\CommandProcess\Salesperson\Dashboard;


use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredLeadsHandler implements Handler
{

    public function handle(Command $command)
    {
        $filters = request()->all();

        $dbQuery =  Lead::select('leads.*', 'lead_status.code as lead_status_code', 'lead_status.name as lead_status_name')
            ->leftJoin('lead_status', 'leads.lead_status_id', 'lead_status.id')
            ->where('leads.salesperson_id', getAdminId())
            ->where(function($query) use ($filters) {
                if (hasInput($filters['name'] ?? '')) {
                    $query->where(
                        DB::raw("CONCAT_WS(' ', leads.first_name, leads.last_name)"), 'LIKE', '%' . $filters['name'] . '%'
                    );
                }
                if (hasInput($filters['country'] ?? '')) {
                    $query->where('leads.country', 'LIKE', '%'.$filters['country'].'%');
                }
                if (hasInput($filters['city'] ?? '')) {
                    $query->where('leads.city', 'LIKE', '%'.$filters['city'].'%');
                }
                if (hasInput($filters['postal_code_start'] ?? '')) {
                    $query->where('leads.postal_code', '>=', $filters['postal_code_start']);
                }
                if (hasInput($filters['postal_code_end'] ?? '')) {
                    $query->where('leads.postal_code', '<=', $filters['postal_code_end']);
                }
                if (hasInput($filters['lead_status_id'] ?? '')) {
                    $query->where('leads.lead_status_id', $filters['lead_status_id']);
                }
            });

        if (hasInput($filters['smart_list_id'] ?? '')) {
            $dbQuery->join('smart_list_leads', 'leads.id', 'smart_list_leads.lead_id')
                ->where('smart_list_leads.smart_list_id', $filters['smart_list_id']);
        }

        return $dbQuery->paginate(12);
    }

}
