<?php

namespace App\CommandProcess\Salesperson\Dashboard;

use Rosamarsky\CommandBus\Command;

class UpdateUserProfile implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
