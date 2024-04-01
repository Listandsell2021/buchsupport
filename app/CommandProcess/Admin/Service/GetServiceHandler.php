<?php

namespace App\CommandProcess\Admin\Service;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\ServicesService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetServiceHandler implements Handler
{

    public ServicesService $dbService;

    public function __construct(ServicesService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getById($command->serviceId);
    }
}
