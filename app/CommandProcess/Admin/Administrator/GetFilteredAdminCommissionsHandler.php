<?php

namespace App\CommandProcess\Admin\Administrator;


use App\Services\Admin\AdminService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredAdminCommissionsHandler implements Handler
{

    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function handle(Command $command)
    {
        return $this->adminService->getPaginatedCommissions($command->data);
    }
}
