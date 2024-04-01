<?php

namespace App\CommandProcess\Customer\Profile;

use App\Http\Resources\Customer\Profile\UserResource;
use App\Models\User;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetUserDetailHandler implements Handler
{

    public function handle(Command $command)
    {
        return new UserResource(User::find($command->userId));
    }

}
