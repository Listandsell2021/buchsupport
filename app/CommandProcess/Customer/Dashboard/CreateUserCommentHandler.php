<?php

namespace App\CommandProcess\Customer\Dashboard;

use App\Models\Comment;
use App\Services\Admin\CommentService;
use Illuminate\Support\Facades\Auth;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class CreateUserCommentHandler implements Handler
{


    public function handle(Command $command)
    {
        return Comment::create([
            'user_id' => getCustomerId(),
            'text' => $command->comment,
            'approved' => 0,
        ]);
    }
}
