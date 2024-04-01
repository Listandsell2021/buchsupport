<?php

namespace App\CommandProcess\Admin\Pipeline;


use App\Http\Resources\Admin\AdminResource;
use App\Models\LeadTask;
use App\Models\Pipeline;
use App\Services\Admin\PipelineService;
use Illuminate\Support\Arr;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StorePipelineHandler implements Handler
{

    private PipelineService $dbService;

    public function __construct(PipelineService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->save(['name' => $command->name]);
    }
}
