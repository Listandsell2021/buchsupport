<?php

namespace App\CommandProcess\Customer\Profile;

use App\Models\User;
use Illuminate\Support\Arr;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateUserDetailHandler implements Handler
{

    public function handle(Command $command)
    {
        $command->data['dob'] = getGlobalDate($command->data['dob']);

        return User::where('id', $command->data['id'])->update(
            Arr::only($command->data, ['first_name', 'last_name', 'dob', 'gender', 'street', 'city', 'postal_code', 'secondary_first_name', 'secondary_last_name'])
        );
    }

}
