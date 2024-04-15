<?php

namespace App\CommandProcess\Admin\Order;

use App\Services\Admin\OrderService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateOrderShipmentHandler implements Handler
{

    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(Command $command)
    {
        $this->orderService->updateOrderShipment($command->orderId, $command->shipmentNo);
    }
}
