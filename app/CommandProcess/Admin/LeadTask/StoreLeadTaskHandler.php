<?php

namespace App\CommandProcess\Admin\LeadTask;


use App\Http\Resources\Admin\AdminResource;
use App\Models\LeadTask;
use App\Services\Admin\LeadTaskService;
use Illuminate\Support\Arr;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreLeadTaskHandler implements Handler
{

    private LeadTaskService $dbService;

    public function __construct(LeadTaskService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $command->data['admin_id'] = getAdminId();

        return $this->dbService->save(Arr::only($command->data, LeadTask::fillableProps()));
    }
}
