<?php

namespace App\CommandProcess\Admin\Administrator;

use App\Services\Admin\AdminService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateAdminBulkActionHandler implements Handler
{

    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function handle(Command $command)
    {
        $message = '';

        if ($command->action == 'delete') {
            $this->adminService->deleteBulk($command->adminIds);
            $message = trans('Admins deleted successfully');
        }

        if ($command->action == 'active') {
            $this->adminService->updateBulkActiveStatus($command->adminIds, 1);
            $message = trans('Admins updated with status active successfully');
        }

        if ($command->action == 'inactive') {
            $this->adminService->updateBulkActiveStatus($command->adminIds, 0);
            $message = trans('Admins updated with status inactive successfully');
        }

        return $message;
    }
}
