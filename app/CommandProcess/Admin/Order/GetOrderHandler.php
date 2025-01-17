<?php

namespace App\CommandProcess\Admin\Order;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\OrderService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetOrderHandler implements Handler
{

    public OrderService $dbService;

    public function __construct(OrderService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $order = $this->dbService->getById($command->orderId);

        $nextStage = $this->dbService->getNextPipelineByOrderId($command->orderId);

        return [
            'order' => $order,
            'next_stage' => $nextStage,
        ];
    }
}
