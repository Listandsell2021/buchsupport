<?php

namespace App\CommandProcess\Admin\AdminRole;


use App\Services\Admin\AdminRoleService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateRoleHandler implements Handler
{

    public AdminRoleService $roleService;

    public function __construct(AdminRoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function handle(Command $command)
    {
        $this->roleService->update($command->roleId, $command->name, $command->status, $command->permissions);

        if ($command->roleId == getAdminRoleId()) {
            setAutomaticallyAdminPermissions();
        }
    }
}
