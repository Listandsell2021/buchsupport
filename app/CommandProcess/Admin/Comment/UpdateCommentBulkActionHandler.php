<?php

namespace App\CommandProcess\Admin\Comment;

use App\Services\Admin\CommentService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateCommentBulkActionHandler implements Handler
{

    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function handle(Command $command)
    {
        $message = '';

        if ($command->action == 'delete') {
            $this->commentService->deleteBulk($command->commentIds);
            $message = trans('Comments deleted successfully');
        }

        if ($command->action == 'lock') {
            $this->commentService->updateBulkApprovedStatus($command->commentIds, 0);
            $message = trans('Comments unapproved successfully');
        }

        if ($command->action == 'unlock') {
            $this->commentService->updateBulkApprovedStatus($command->commentIds, 1);
            $message = trans('Comments approved successfully');
        }

        return $message;
    }
}
