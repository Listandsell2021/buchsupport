<?php

namespace App\CommandProcess\Admin\Administrator;


use App\Services\Admin\AdminService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredAdminsHandler implements Handler
{

    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function handle(Command $command)
    {
        return $this->adminService->searchAndPaginate($command->data);
    }
}
