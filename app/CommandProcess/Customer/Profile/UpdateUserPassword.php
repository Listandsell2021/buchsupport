<?php

namespace App\CommandProcess\Customer\Profile;

use Rosamarsky\CommandBus\Command;

class UpdateUserPassword implements Command
{
    public int $userId;
    public string $password;

    public function __construct(int $userId, string $password)
    {
        $this->userId = $userId;
        $this->password = $password;
    }
}
