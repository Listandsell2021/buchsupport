<?php

namespace App\CommandProcess\Admin\ServicePipeline;

use Rosamarsky\CommandBus\Command;

class UpdateServicePipeline implements Command
{
    public int $pipelineId;
    public array $data;

    public function __construct(int $pipelineId, array $data)
    {
        $this->pipelineId = $pipelineId;
        $this->data = $data;
    }
}
