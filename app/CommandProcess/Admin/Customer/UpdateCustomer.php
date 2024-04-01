<?php

namespace App\CommandProcess\Admin\Customer;

use Rosamarsky\CommandBus\Command;

class UpdateCustomer implements Command
{
    public int $customerId;
    public array $data;

    public function __construct(int $customerId, array $data)
    {
        $this->customerId = $customerId;
        $this->data = $data;
    }
}
