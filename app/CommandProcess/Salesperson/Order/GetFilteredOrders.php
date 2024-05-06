<?php

namespace App\CommandProcess\Salesperson\Order;

use Rosamarsky\CommandBus\Command;

class GetFilteredOrders implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
