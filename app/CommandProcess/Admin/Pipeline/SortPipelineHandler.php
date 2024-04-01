<?php

namespace App\CommandProcess\Admin\Pipeline;


use App\DataHolders\Enum\PipelineSortingEvent;
use App\Services\Admin\PipelineService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class SortPipelineHandler implements Handler
{

    private PipelineService $dbService;

    public function __construct(PipelineService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->sort($command->pipelineId, $command->userIds);
    }
}
