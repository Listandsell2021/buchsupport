<?php

namespace App\Services\Admin;

use App\Helpers\Trait\AuthHelper;
use App\Models\Admin;
use App\Models\AdminCommission;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AdminService {

    use AuthHelper;

    /**
     * Get all records with pagination.
     *
     * @param array $data
     * @return mixed
     */
    public function searchAndPaginate(array $data): mixed
    {
        $filters = $data['filters'] ?? [];

        return Admin::select('*', 'admins.id as id', 'admin_roles.name as role_name', 'admins.is_active as is_active')
            ->leftJoin('admin_roles', 'admins.role_id', 'admin_roles.id')
            ->where(function($query) use ($filters) {
                if (hasInput($filters['name'] ?? '')) {
                    $query->where(
                        DB::raw("CONCAT_WS(' ', admins.first_name, admins.last_name)"), 'LIKE', '%' . $filters['name'] . '%'
                    );
                }
                if (hasInput($filters['email'] ?? '')) {
                    $query->where('admins.email', 'LIKE', '%'.$filters['email'].'%');
                }
                if (hasInput($filters['gender'] ?? '')) {
                    $query->where('admins.gender', '=', $filters['gender']);
                }
                if (hasInput($filters['city'] ?? '')) {
                    $query->where('admins.city', 'LIKE', '%'.$filters['city'].'%');
                }
                if (hasInput($filters['role_id'] ?? '')) {
                    $query->where('admins.role_id', $filters['role_id']);
                }
                if (hasInput($filters['auth_role'] ?? '')) {
                    $query->where('admins.auth_role', $filters['auth_role']);
                }
                if (hasInput($filters['is_active'] ?? '')) {
                    $query->where('admins.is_active', (int) $filters['is_active']);
                }

                $this->filterAdminByAuthRole($query);

            })
            ->sorting([
                'admins.id', 'admins.first_name', 'admins.last_name', 'admins.email', 'admins.dob',
                'admins.gender', 'admins.city', 'admins.auth_role', 'role_name', 'admins.is_active'
            ], 'admins.id', 'desc')
            ->paginate(getPerPageTotal());
    }

    /**
     * Get specific record by id.
     *
     * @param int $adminId
     * @return mixed
     */
    public function getById(int $adminId): mixed
    {
        return Admin::findOrFail($adminId);
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        return Admin::create(Arr::only($data, Admin::fillableProps()));
    }

    /**
     * Update specific record to database.
     *
     * @param int $adminId
     * @param array $data
     * @return bool
     */
    public function update(int $adminId, array $data): bool
    {
        return (bool) Admin::where('id', $adminId)->update(Arr::only($data, Admin::fillableProps()));
    }

    /**
     * Delete specific record.
     *
     * @param int $adminId
     * @return bool
     */
    public function delete(int $adminId): bool
    {
        return (bool) Admin::where('id', $adminId)->delete();
    }


    /**
     * Delete specific record.
     *
     * @param array $adminIds
     * @return bool
     */
    public function deleteBulk(array $adminIds): bool
    {
        return (bool) Admin::whereIn('id', $adminIds)->delete();
    }


    /**
     * Update Active Status
     *
     * @param int $adminId
     * @param int $isActive
     * @return bool
     */
    public function updateActiveStatus(int $adminId, int $isActive): bool
    {
        return (bool) Admin::where('id', $adminId)->update(['is_active' => $isActive]);
    }


    /**
     * Update Bulk Active Status
     *
     * @param array $adminIds
     * @param int $isActive
     * @return bool
     */
    public function updateBulkActiveStatus(array $adminIds, int $isActive): bool
    {
        return (bool) Admin::whereIn('id', $adminIds)->update(['is_active' => $isActive]);
    }


    /**
     * Get Active Salespersons
     *
     * @return mixed
     */
    public function getActiveSalespersons(): mixed
    {
        return Admin::select('*', DB::raw('CONCAT(admins.first_name, " ", admins.last_name) as fullname'))
            ->salesperson()
            ->active()
            ->orderBy('admins.first_name')
            ->get();
    }



    /**
     * Get all records with pagination.
     *
     * @param array $data
     * @return mixed
     */
    public function getPaginatedCommissions(array $data): mixed
    {
        $filters = $data['filters'] ?? [];

        return AdminCommission::where(function($query) use ($filters) {
                if (hasInput($filters['name'] ?? '')) {
                    $query->where(
                        DB::raw("CONCAT_WS(' ', admins.first_name, admins.last_name)"), 'LIKE', '%' . $filters['name'] . '%'
                    );
                }
                $this->filterAdminByAuthRole($query);

            })
            ->where('admin_commissions.admin_id', $filters['admin_id'] ?? 0)
            ->sorting([
                'admin_commissions.id', 'admin_commissions.commission_from',
                'admin_commissions.commission_date', 'admins.is_active'
            ], 'admin_commissions.id', 'desc')
            ->paginate(getPerPageTotal());
    }


    /**
     * Update Admin Commission Paid Status
     *
     * @param int $commissionId
     * @param int $paid
     * @return bool
     */
    public function updateCommissionPaidStatus(int $commissionId, int $paid): bool
    {
        return (bool) AdminCommission::where('id', $commissionId)->update(['paid' => $paid]);
    }


    /**
     * Get Commission ID
     *
     * @param int $commissionId
     * @return mixed
     */
    public function getCommissionById(int $commissionId): mixed
    {
        return AdminCommission::find($commissionId);
    }


}
