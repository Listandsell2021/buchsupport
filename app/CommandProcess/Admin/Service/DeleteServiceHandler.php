<?php

namespace App\CommandProcess\Admin\Service;


use App\Services\Admin\ServicesService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteServiceHandler implements Handler
{

    private ServicesService $dbService;

    /**
     * @param ServicesService $dbService
     */
    public function __construct(ServicesService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->delete($command->serviceId);
    }
}
