<?php

namespace App\CommandProcess\Admin\Order;


use App\Services\Admin\OrderService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredOrdersHandler implements Handler
{

    private OrderService $dbService;

    public function __construct(OrderService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->searchAndPaginate($command->data);
    }
}
