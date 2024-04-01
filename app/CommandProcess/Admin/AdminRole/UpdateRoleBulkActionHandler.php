<?php

namespace App\CommandProcess\Admin\AdminRole;

use App\Services\Admin\AdminRoleService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateRoleBulkActionHandler implements Handler
{

    private AdminRoleService $roleService;

    public function __construct(AdminRoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function handle(Command $command)
    {
        $message = '';

        if ($command->action == 'delete') {
            $this->roleService->deleteBulk($command->roleIds);
            $message = trans('Roles deleted successfully');
        }

        if ($command->action == 'active') {
            $this->roleService->updateBulkActiveStatus($command->roleIds, 1);
            $message = trans('Roles updated with status active successfully');
        }

        if ($command->action == 'inactive') {
            $this->roleService->updateBulkActiveStatus($command->roleIds, 0);
            $message = trans('Roles updated with status inactive successfully');
        }

        return $message;
    }
}
