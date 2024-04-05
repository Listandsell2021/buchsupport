<?php

namespace App\CommandProcess\Admin\Order;

use Rosamarsky\CommandBus\Command;

class UpdateOrder implements Command
{
    public int $orderId;
    public array $data;

    public function __construct(int $orderId, array $data)
    {
        $this->orderId = $orderId;
        $this->data = $data;
    }
}
