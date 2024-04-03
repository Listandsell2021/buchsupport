<?php

namespace App\CommandProcess\Admin\ServicePipeline;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\ServicePipelineService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetServicePipelineHandler implements Handler
{

    public ServicePipelineService $dbService;

    public function __construct(ServicePipelineService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getById($command->serviceId);
    }
}
