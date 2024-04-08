<?php

namespace App\CommandProcess\Admin\Lead;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\LeadService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreLeadHandler implements Handler
{
    private LeadService $dbService;

    public function __construct(LeadService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        if (isAuthSalesperson()) {
            $command->data['salesperson_id'] = getAdminId();
        }

        return $this->dbService->save(array_merge($command->data, ['created_by' => getAdminId()]));
    }
}
