<?php

namespace App\CommandProcess\Admin\AdminRole;

use Rosamarsky\CommandBus\Command;

class UpdateRoleBulkAction implements Command
{
    public array $roleIds;
    public string $action;

    public function __construct(array $roleIds, string $action)
    {
        $this->roleIds = $roleIds;
        $this->action = $action;
    }
}
