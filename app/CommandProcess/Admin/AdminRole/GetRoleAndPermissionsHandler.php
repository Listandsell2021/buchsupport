<?php

namespace App\CommandProcess\Admin\AdminRole;


use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\AdminRoleService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetRoleAndPermissionsHandler implements Handler
{

    public AdminRoleService $roleService;

    public function __construct(AdminRoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function handle(Command $command)
    {
        return new RoleResource($this->roleService->getWithPermissionsById($command->roleId));
    }
}
