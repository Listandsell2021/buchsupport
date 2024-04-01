<?php

namespace App\CommandProcess\Admin\Administrator;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\AdminService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreAdminHandler implements Handler
{


    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function handle(Command $command)
    {
        $command->data['dob'] = getGlobalDate($command->data['dob']);
        $command->data['is_admin'] = 1;
        $admin = $this->adminService->save($command->data);

        return new AdminResource($admin);
    }
}
