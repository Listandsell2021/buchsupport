<?php

namespace App\CommandProcess\Admin\Pipeline;

use Rosamarsky\CommandBus\Command;

class AddCustomerToPipeline implements Command
{
    public int $pipelineId;
    public int $userId;

    public function __construct(int $pipelineId, int $userId)
    {
        $this->pipelineId = $pipelineId;
        $this->userId = $userId;
    }
}
