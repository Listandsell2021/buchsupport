<?php

namespace App\CommandProcess\Admin\Mail;

use Rosamarsky\CommandBus\Command;

class UpdateMail implements Command
{
    public int $mailId;
    public array $data;

    public function __construct(int $mailId, array $data)
    {
        $this->mailId = $mailId;
        $this->data = $data;
    }
}
