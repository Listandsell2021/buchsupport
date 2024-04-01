<?php

namespace App\CommandProcess\Admin\Comment;


use App\Services\Admin\CommentService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredCommentsHandler implements Handler
{

    private CommentService $dbService;

    public function __construct(CommentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->searchAndPaginate($command->data);
    }
}
