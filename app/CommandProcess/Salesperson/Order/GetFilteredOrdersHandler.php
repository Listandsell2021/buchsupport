<?php

namespace App\CommandProcess\Salesperson\Order;


use App\Services\Admin\OrderService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredOrdersHandler implements Handler
{

    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(Command $command)
    {
        return $this->orderService->searchAndPaginate($command->data);
    }
}
