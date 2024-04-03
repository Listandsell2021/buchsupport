<?php

namespace App\CommandProcess\Admin\ServicePipeline;


use App\Services\Admin\ServicePipelineService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateServicePipelineHandler implements Handler
{
    public ServicePipelineService $dbService;

    public function __construct(ServicePipelineService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command): void
    {
        $this->dbService->update($command->pipelineId, $command->data);
    }
}
