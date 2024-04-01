<?php

namespace App\CommandProcess\Admin\Customer;

use Rosamarsky\CommandBus\Command;

class UpdateCustomerActiveStatus implements Command
{
    public int $customerId;
    public int $status;

    public function __construct(int $customerId, int $status)
    {
        $this->customerId = $customerId;
        $this->status = $status;
    }
}
