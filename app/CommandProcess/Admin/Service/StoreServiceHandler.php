<?php

namespace App\CommandProcess\Admin\Service;


use App\Services\Admin\ServicesService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreServiceHandler implements Handler
{
    private ServicesService $dbService;

    public function __construct(ServicesService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->save($command->data);
    }
}
