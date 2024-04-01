<?php

namespace App\CommandProcess\Admin\Customer;

use Rosamarsky\CommandBus\Command;

class SortCustomerProducts implements Command
{
    public int $userId;
    public array $userProductIds;

    public function __construct(int $userId, array $userProductIds)
    {
        $this->userId = $userId;
        $this->userProductIds = $userProductIds;
    }
}
