<?php

namespace App\CommandProcess\Admin\Order;

use Rosamarsky\CommandBus\Command;

class UpdateOrderToLastPipeline implements Command
{
    public int $orderId;
    public int $pipelineId;
    public string $status;

    public function __construct(int $orderId, int $pipelineId, string $status)
    {
        $this->orderId = $orderId;
        $this->pipelineId = $pipelineId;
        $this->status = $status;
    }
}
