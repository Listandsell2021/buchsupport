<?php

namespace App\CommandProcess\Admin\Order;


use App\Services\Admin\OrderService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteOrderHandler implements Handler
{

    private OrderService $dbService;

    /**
     * @param OrderService $dbService
     */
    public function __construct(OrderService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->delete($command->orderId);
    }
}
