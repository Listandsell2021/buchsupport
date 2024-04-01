<?php

namespace App\CommandProcess\Admin\Pipeline;

use Rosamarsky\CommandBus\Command;

class SortPipeline implements Command
{
    public int $pipelineId;
    public array $userIds;

    public function __construct(int $pipelineId, array $userIds)
    {
        $this->pipelineId = $pipelineId;
        $this->userIds = $userIds;
    }
}
