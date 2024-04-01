<?php

namespace App\Helpers\Trait;

use App\DataHolders\Enum\AuthRole;


trait AuthHelper
{


    /**
     * Filter By Branch ID
     *
     * @param $query
     */
    public function filterAdminByAuthRole($query): void
    {
        if (!isAuthSuperAdmin()) {
            $query->where('admins.auth_role', '!=', AuthRole::getSuperAdminRole());
        }
    }


}
