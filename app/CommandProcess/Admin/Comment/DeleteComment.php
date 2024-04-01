<?php

namespace App\CommandProcess\Admin\Comment;

use Rosamarsky\CommandBus\Command;

class DeleteComment implements Command
{
    public int $commentId;

    public function __construct(int $commentId)
    {
        $this->commentId = $commentId;
    }
}
