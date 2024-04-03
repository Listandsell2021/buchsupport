<?php

namespace App\CommandProcess\Admin\ServicePipeline;

use Rosamarsky\CommandBus\Command;

class ChangeDefaultServicePipeline implements Command
{
    public int $pipelineId;
    public int $default;

    public function __construct(int $pipelineId, int $default)
    {
        $this->pipelineId = $pipelineId;
        $this->default = $default;
    }
}
