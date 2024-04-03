<?php

namespace App\CommandProcess\Admin\ServicePipeline;


use App\Services\Admin\ServicePipelineService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredServicePipelinesHandler implements Handler
{

    private ServicePipelineService $dbService;

    public function __construct(ServicePipelineService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->searchAndPaginate($command->data);
    }
}
