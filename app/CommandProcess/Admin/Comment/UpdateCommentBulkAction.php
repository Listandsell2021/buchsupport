<?php

namespace App\CommandProcess\Admin\Comment;

use Rosamarsky\CommandBus\Command;

class UpdateCommentBulkAction implements Command
{
    public array $commentIds;
    public string $action;

    public function __construct(array $commentIds, string $action)
    {
        $this->commentIds = $commentIds;
        $this->action = $action;
    }
}
