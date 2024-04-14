<?php

namespace App\CommandProcess\Admin\Order;

use Rosamarsky\CommandBus\Command;

class DownloadOrderContractDocument implements Command
{
    public int $orderId;

    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }
}
