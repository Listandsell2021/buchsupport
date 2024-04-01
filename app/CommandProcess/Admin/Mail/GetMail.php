<?php

namespace App\CommandProcess\Admin\Mail;

use Rosamarsky\CommandBus\Command;

class GetMail implements Command
{
    public int $mailId;

    public function __construct(int $mailId)
    {
        $this->mailId = $mailId;
    }
}
