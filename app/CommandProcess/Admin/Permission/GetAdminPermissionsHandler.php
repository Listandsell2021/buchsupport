<?php

namespace App\CommandProcess\Admin\Permission;


use App\DataHolders\Enum\AdminPermission;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetAdminPermissionsHandler implements Handler
{


    public function handle(Command $command)
    {
        return AdminPermission::all();
    }
}
