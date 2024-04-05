<?php

namespace App\CommandProcess\Admin\Order;

use Rosamarsky\CommandBus\Command;

class UpdateOrderPipeline implements Command
{
    public int $orderId;
    public int $pipelineId;
    public int $orderNo;

    public function __construct(int $orderId, int $pipelineId, int $orderNo)
    {
        $this->orderId = $orderId;
        $this->pipelineId = $pipelineId;
        $this->orderNo = $orderNo;
    }
}
