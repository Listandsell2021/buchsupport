<?php

namespace App\CommandProcess\Admin\Customer;

use Rosamarsky\CommandBus\Command;

class StoreCustomer implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
