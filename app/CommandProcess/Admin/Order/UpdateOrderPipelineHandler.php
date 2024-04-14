<?php

namespace App\CommandProcess\Admin\Order;


use App\Services\Admin\OrderService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateOrderPipelineHandler implements Handler
{
    public OrderService $dbService;

    public function __construct(OrderService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command): void
    {
        $this->dbService->updatePipeline($command->orderId, $command->pipelineId, $command->orderNo);
        $this->dbService->updateOrderStage((int) $command->orderId, (int) $command->pipelineId);
    }
}
