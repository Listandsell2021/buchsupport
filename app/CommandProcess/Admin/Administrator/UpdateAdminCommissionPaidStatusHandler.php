<?php

namespace App\CommandProcess\Admin\Administrator;

use App\Services\Admin\AdminService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateAdminCommissionPaidStatusHandler implements Handler
{
    public AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function handle(Command $command)
    {
        $this->adminService->updateCommissionPaidStatus($command->commissionId, $command->paid);
    }
}
