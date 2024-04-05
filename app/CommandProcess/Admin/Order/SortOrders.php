<?php

namespace App\CommandProcess\Admin\Order;

use Rosamarsky\CommandBus\Command;

class SortOrders implements Command
{
    public array $orderIds;

    public function __construct(array $orderIds)
    {
        $this->orderIds = $orderIds;
    }
}
