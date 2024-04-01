<?php

namespace App\CommandProcess\Admin\AdminRole;


use App\Services\Admin\AdminRoleService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateRoleActiveStatusHandler implements Handler
{

    public AdminRoleService $roleService;

    public function __construct(AdminRoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function handle(Command $command)
    {
        $this->roleService->updateActiveStatus($command->roleId, $command->status);
    }
}
