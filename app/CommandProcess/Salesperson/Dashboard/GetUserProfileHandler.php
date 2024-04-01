<?php

namespace App\CommandProcess\Salesperson\Dashboard;

use App\Http\Resources\Salesperson\AdminResource;
use App\Models\Admin;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetUserProfileHandler implements Handler
{
    public function handle(Command $command)
    {
        return new AdminResource(Admin::find(getAdminId()));
    }
}
