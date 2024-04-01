<?php

namespace App\CommandProcess\Admin\Service;

use Rosamarsky\CommandBus\Command;

class StoreService implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
