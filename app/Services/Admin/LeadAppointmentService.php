<?php

namespace App\Services\Admin;

use App\Models\LeadAppointment;
use Illuminate\Support\Facades\DB;

class LeadAppointmentService
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

        return LeadAppointment::select('lead_appointments.*',
            DB::raw('CONCAT(admins.first_name, " ", admins.last_name) as created_by')
        )
            ->leftJoin('admins', 'lead_appointments.admin_id', 'admins.id')
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
     * @param int $appointmentId
     * @return mixed
     */
    public function getById(int $appointmentId): mixed
    {
        return LeadAppointment::find($appointmentId);
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        return LeadAppointment::create($data);
    }

    /**
     * Update specific record to database.
     *
     * @param int $appointmentId
     * @param array $data
     * @return void
     */
    public function update(int $appointmentId, array $data)
    {
        LeadAppointment::where('id', $appointmentId)->update($data);
    }

    /**
     * Delete specific record.
     *
     * @param int $appointmentId
     * @return void
     */
    public function delete(int $appointmentId): void
    {
        LeadAppointment::where('id', $appointmentId)->delete();
    }


}
