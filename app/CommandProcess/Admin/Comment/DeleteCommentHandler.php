<?php

namespace App\CommandProcess\Admin\Comment;


use App\Services\Admin\CommentService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteCommentHandler implements Handler
{

    private CommentService $dbService;

    /**
     * @param CommentService $dbService
     */
    public function __construct(CommentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->delete($command->commentId);
    }
}
