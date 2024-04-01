<?php

namespace App\Helpers\EloquentFilters\Admin;

use App\Services\Admin\LeadService;

class LeadFilter
{

    public static function getLeadIdsBySearchFilters(): array
    {
        $filters = (array) request('filters');
        $leadIds = (array) ($filters['lead_ids'] ?? []);

        if (isset($filters['select_all']) && $filters['select_all'] == 1) {
            $leadIds = (new LeadService())->getSearchQuery(request()->all())
                ->get()
                ->pluck('id')
                ->toArray();
        }
        return $leadIds;
    }

}