<?php

namespace App\CommandProcess\Admin\Order;

use Rosamarsky\CommandBus\Command;

class UpdateOrderShipment implements Command
{
    public int $orderId;
    public string $shipmentNo;

    public function __construct(int $orderId, string $shipmentNo)
    {
        $this->orderId = $orderId;
        $this->shipmentNo = $shipmentNo;
    }
}
