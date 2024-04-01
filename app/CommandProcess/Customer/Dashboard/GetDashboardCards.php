<?php

namespace App\CommandProcess\Customer\Dashboard;

use Rosamarsky\CommandBus\Command;

class GetDashboardCards implements Command
{
    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
