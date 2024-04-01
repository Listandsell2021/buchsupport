<?php

namespace App\CommandProcess\Admin\Comment;

use Rosamarsky\CommandBus\Command;

class UpdateCommentApprovedStatus implements Command
{
    public int $commentId;
    public int $status;

    public function __construct(int $commentId, int $status)
    {
        $this->commentId = $commentId;
        $this->status = $status;
    }
}
