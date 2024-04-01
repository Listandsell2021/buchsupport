<?php

namespace App\CommandProcess\Customer\Profile;

use Rosamarsky\CommandBus\Command;

class GetUserDetail implements Command
{
    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
