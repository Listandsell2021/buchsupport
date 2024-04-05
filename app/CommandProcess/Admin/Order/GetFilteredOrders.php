<?php

namespace App\CommandProcess\Admin\Order;

use Rosamarsky\CommandBus\Command;

class GetFilteredOrders implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
