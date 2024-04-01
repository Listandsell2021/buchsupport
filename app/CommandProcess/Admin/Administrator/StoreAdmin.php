<?php

namespace App\CommandProcess\Admin\Administrator;

use Rosamarsky\CommandBus\Command;

class StoreAdmin implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
