<?php

namespace App\CommandProcess\Admin\Administrator;


use App\Services\Admin\AdminService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateAdminHandler implements Handler
{

    public AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function handle(Command $command)
    {
        if (empty($command->data['password'])) {
            unset($command->data['password']);
        } else {
            $command->data['password'] = bcrypt($command->data['password']);
        }
        $command->data['dob'] = getGlobalDate($command->data['dob']);

        $this->adminService->update($command->adminId, $command->data);

        if ($command->adminId == getAuthAdmin()->id) {
            setAutomaticallyAdminPermissions();
        }

    }
}
