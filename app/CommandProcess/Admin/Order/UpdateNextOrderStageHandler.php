<?php

namespace App\CommandProcess\Admin\Order;

use App\Services\Admin\OrderService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateNextOrderStageHandler implements Handler
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function handle(Command $command): void
    {
        $nextPipeline = $this->orderService->getNextPipelineByOrderId((int) $command->orderId);
        if ($nextPipeline) {
            $this->orderService->updateOrderStage((int) $command->orderId, $nextPipeline->id);
        }
    }
}
