<?php

namespace App\CommandProcess\Salesperson\Dashboard;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateUserProfileHandler implements Handler
{

    public function handle(Command $command)
    {
        return Admin::where('id', getAdminId())->update(Arr::only($command->data, Arr::except(Admin::fillableProps(), ['auth_role', 'role_id', 'is_active'])));
    }
}
