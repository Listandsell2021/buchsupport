<?php

namespace App\CommandProcess\Admin\Mail;

use Rosamarsky\CommandBus\Command;

class GetFilteredMails implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
