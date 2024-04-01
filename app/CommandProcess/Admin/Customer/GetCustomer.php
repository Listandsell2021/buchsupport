<?php

namespace App\CommandProcess\Admin\Customer;

use Rosamarsky\CommandBus\Command;

class GetCustomer implements Command
{
    public int $customerId;

    public function __construct(int $customerId)
    {
        $this->customerId = $customerId;
    }
}
