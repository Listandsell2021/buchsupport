<?php

namespace App\CommandProcess\Admin\Service;

use App\Services\Admin\ServicesService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetAllServicesHandler implements Handler
{

    private ServicesService $dbService;

    public function __construct(ServicesService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getAllServices();
    }
}
