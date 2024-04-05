<?php

namespace App\CommandProcess\Admin\Order;


use App\Services\Admin\OrderService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateOrderHandler implements Handler
{
    public OrderService $dbService;

    public function __construct(OrderService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command): void
    {
        $this->dbService->update($command->orderId, $command->data);
    }
}
