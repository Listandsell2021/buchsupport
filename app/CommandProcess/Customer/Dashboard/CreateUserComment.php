<?php

namespace App\CommandProcess\Customer\Dashboard;

use Rosamarsky\CommandBus\Command;

class CreateUserComment implements Command
{
    public string $comment;

    public function __construct(string $comment)
    {
        $this->comment = $comment;
    }
}
