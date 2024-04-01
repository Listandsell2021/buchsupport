<?php

namespace App\CommandProcess\Admin\AdminRole;

use Rosamarsky\CommandBus\Command;

class UpdateRoleActiveStatus implements Command
{
    public int $roleId;
    public int $status;

    public function __construct(int $roleId, int $status)
    {
        $this->roleId = $roleId;
        $this->status = $status;
    }
}
