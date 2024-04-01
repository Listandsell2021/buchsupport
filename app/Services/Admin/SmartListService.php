<?php

namespace App\Services\Admin;

use App\Helpers\Config\AuthConfig;
use App\Models\Lead;
use App\Models\SmartList;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SmartListService
{

    public function getAdminSmartList()
    {
        return SmartList::withCount('leads')
            ->withCount('active_leads')
            ->withCount('inactive_leads')
            ->where('admin_id', getAdminId())
            ->get();
    }

    /**
     * Get Admin Smart List Details
     *
     * @return mixed
     */
    public function getAdminSmartListDetails(): mixed
    {
        return SmartList::withCount('leads')
            ->withCount('active_leads')
            ->withCount('inactive_leads')
            ->where('admin_id', getAdminId())
            ->get();
    }


    /**
    * Get specific record by id.
    *
    * @param int $id
    * @return mixed
    */
    public function getById($id)
    {
        return SmartList::find($id);
    }

    /**
     * Store data to database.
     *
     * @param array $leadIds
     * @param string $name
     * @param int $salespersonId
     * @return mixed
     */
    public function save(array $leadIds, string $name, int $salespersonId): mixed
    {
        $smartList = SmartList::create([
            'name'      => $name,
            'admin_id'  => getAdminId(),
        ]);

        $smartListLeads = [];
        $i = 1;
        foreach ($leadIds as $leadId) {
            $smartListLeads[] = [
                'smart_list_id' => $smartList->id,
                'lead_id' => $leadId,
                'order_no' => $i++
            ];
        }

        foreach (array_chunk($smartListLeads, 50) as $smartLeads) {
            DB::table('smart_list_leads')->insert($smartLeads);
        }

        if ($salespersonId > 0) {
            foreach (array_chunk($leadIds, 50) as $chunkedLeadIds) {
                Lead::whereIn('id', $chunkedLeadIds)->update(['salesperson_id' => $salespersonId]);
            }
        }

        return $smartList;
    }


    /**
     * Delete specific record.
     *
     * @param int $smartListId
     * @return void
     */
    public function delete(int $smartListId): void
    {
        SmartList::where('id', $smartListId)->delete();
    }

    /**
     * Get Smart list leads
     *
     * @param $smartListId
     * @return Collection
     */
    public function getSmartListLeads($smartListId): Collection
    {
        return DB::table('smart_list_leads')
            ->join('leads', 'smart_list_leads.lead_id', 'leads.id')
            ->where('smart_list_leads.smart_list_id', $smartListId)
            ->get();
    }


}