<?php

namespace App\CommandProcess\Admin\ServicePipeline;

use App\Services\Admin\ServicePipelineService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class ChangeDefaultServicePipelineHandler implements Handler
{
    private ServicePipelineService $dbService;

    public function __construct(ServicePipelineService $dbService)
    {

        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->changeDefault($command->pipelineId, $command->default);
    }
}
