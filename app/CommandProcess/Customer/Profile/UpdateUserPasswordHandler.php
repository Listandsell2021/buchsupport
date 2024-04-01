<?php

namespace App\CommandProcess\Customer\Profile;

use App\Models\User;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateUserPasswordHandler implements Handler
{

    public function handle(Command $command)
    {
        return User::where('id', $command->userId)->update([
            'password'      => bcrypt($command->password),
            'password_text' => $command->password
        ]);
    }

}
