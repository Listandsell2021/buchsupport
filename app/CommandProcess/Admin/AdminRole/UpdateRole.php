<?php

namespace App\CommandProcess\Admin\AdminRole;

use Rosamarsky\CommandBus\Command;

class UpdateRole implements Command
{
    public int $roleId;
    public string $name;
    public int $status;
    public array $permissions;

    public function __construct(int $roleId, string $name, int $status, array $permissions)
    {
        $this->roleId = $roleId;
        $this->name = $name;
        $this->status = $status;
        $this->permissions = $permissions;
    }
}
