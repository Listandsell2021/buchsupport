<?php

namespace App\CommandProcess\Customer\Dashboard;

use Rosamarsky\CommandBus\Command;

class ReverseProductView implements Command
{
    public int $userProductId;

    public function __construct(int $userProductId)
    {
        $this->userProductId = $userProductId;
    }
}
