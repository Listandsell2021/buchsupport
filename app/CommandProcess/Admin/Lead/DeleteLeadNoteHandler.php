<?php

namespace App\CommandProcess\Admin\Lead;

use App\Models\LeadNote;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteLeadNoteHandler implements Handler
{

    public function handle(Command $command)
    {
        return LeadNote::where('id', $command->noteId)->delete();
    }
}
