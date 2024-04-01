<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class DeleteLeadNote implements Command
{
    public int $noteId;

    public function __construct(int $noteId)
    {
        $this->noteId = $noteId;
    }
}
