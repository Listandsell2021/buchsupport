<?php

namespace App\CommandProcess\Admin\AdminRole;


use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\AdminRoleService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreRoleHandler implements Handler
{

    public AdminRoleService $roleService;

    public function __construct(AdminRoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function handle(Command $command)
    {
        $role = $this->roleService->save($command->name, $command->status, $command->permissions);

        return new RoleResource($role);
    }
}
