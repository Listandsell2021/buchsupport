<?php

namespace App\CommandProcess\Admin\LeadStatus;


use App\Services\Admin\LeadStatusService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreLeadStatusHandler implements Handler
{
    private LeadStatusService $dbService;

    public function __construct(LeadStatusService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $data = $command->data;
        $data['default'] = (int) ((bool) isset($data['default'])? $data['default'] : 0);
        $data['order_no'] = $this->dbService->getIncrementalOrderNo();

        return $this->dbService->save($data);
    }
}
