<?php

namespace App\CommandProcess\Admin\Comment;


use App\Services\Admin\CommentService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateCommentApprovedStatusHandler implements Handler
{

    public CommentService $dbService;

    public function __construct(CommentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->updateApprovedStatus($command->commentId, $command->status);
    }
}
