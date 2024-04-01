<?php

namespace App\Services\Admin;


use App\Models\AdminRole;
use App\Models\AdminPermission;
use Illuminate\Http\Request;

class AdminRoleService
{

    /**
     * Get all records.
     *
     * @param Request $request
     * @return mixed
     */
    public function searchAndPaginate(Request $request): mixed
    {
        $filters = (array) $request->get('filters');

        return AdminRole::where(function($query) use ($filters) {
                if (hasInput($filters['name'] ?? '')) {
                    $query->where('admin_roles.name', 'LIKE', '%' . $filters['name'] . '%');
                }
                if (hasInput($filters['is_active'] ?? '')) {
                    $query->where('admin_roles.is_active', (int) $filters['is_active']);
                }
            })
            ->sorting(['admin_roles.id', 'admin_roles.name', 'admin_roles.is_active'], 'admin_roles.id')
            ->paginate(getPerPageTotal());
    }


    /**
    * Get specific record by id.
    *
    * @param int $id
    * @return AdminRole
    */
    public function getById($id)
    {
        return AdminRole::findOrFail($id);
    }

    /**
     * Store data to database.
     *
     * @param string $name
     * @param int $status
     * @param array $permissions
     * @return AdminRole
     */
    public function save(string $name, int $status, array $permissions): AdminRole
    {
        $role =  AdminRole::create(['name' => $name, 'status' => $status]);

        if (count($permissions) > 0) {
            $permissions = array_map(function ($permission) use ($role) {
                return ['role_id' => $role->id, 'permission' => $permission];
            }, $permissions);

            AdminPermission::insert($permissions);
        }

        return $role;
    }

    /**
     * Update specific record to database.
     *
     * @param int $roleId
     * @param string $name
     * @param int $status
     * @param array $permissions
     * @return void
     */
    public function update(int $roleId, string $name, int $status, array $permissions): void
    {
        AdminRole::where('id', $roleId)->update([
            'name' => $name,
            'is_active' => $status,
        ]);

        AdminPermission::where('role_id', $roleId)->delete();

        if (count($permissions) == 0) {
            return;
        }

        $permissions = array_map(function ($permission) use ($roleId) {
            return ['role_id' => $roleId, 'permission' => $permission];
        }, $permissions);

        AdminPermission::insert($permissions);
    }

    /**
     * Delete specific record.
     *
     * @param int $roleId
     * @return void
     */
    public function delete(int $roleId): void
    {
        AdminRole::where('id', $roleId)->delete();
    }


    /**
     * Delete Bulk
     *
     * @param array $roleIds
     * @return void
     */
    public function deleteBulk(array $roleIds): void
    {
        AdminRole::whereIn('id', $roleIds)->where('default', 0)->delete();
    }


    /**
     * Update Active Status
     *
     * @param int $roleId
     * @param int $isActive
     * @return void
     */
    public function updateActiveStatus(int $roleId, int $isActive): void
    {
        AdminRole::where('id', $roleId)->update(['is_active' => $isActive]);
    }


    /**
     * Update Bulk Active Status
     *
     * @param array $roleIds
     * @param int $isActive
     * @return void
     */
    public function updateBulkActiveStatus(array $roleIds, int $isActive): void
    {
        AdminRole::whereIn('id', $roleIds)->where('default', 0)->update(['is_active' => $isActive]);
    }


    /**
     * Get All Permissions
     *
     * @return array
     */
    public function getPermissions()
    {
        return \App\DataHolders\Enum\AdminPermission::all();
    }

    /**
     * Get AdminRole with permissions
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getWithPermissionsById(int $roleId)
    {
        return AdminRole::with('permissions')->where('id', $roleId)->first();
    }

    /**
     * Get Active Roles
     *
     * @return mixed
     */
    public function getActiveRoles(): mixed
    {
        return AdminRole::where('is_active', 1)->get();
    }
}
