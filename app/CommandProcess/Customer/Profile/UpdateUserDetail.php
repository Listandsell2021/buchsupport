<?php

namespace App\CommandProcess\Customer\Profile;

use Rosamarsky\CommandBus\Command;

class UpdateUserDetail implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
