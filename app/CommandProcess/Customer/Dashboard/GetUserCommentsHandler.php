<?php

namespace App\CommandProcess\Customer\Dashboard;

use App\Models\Comment;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetUserCommentsHandler implements Handler
{


    public function handle(Command $command)
    {
        return Comment::where('user_id', $command->userId)->get();
    }
}
