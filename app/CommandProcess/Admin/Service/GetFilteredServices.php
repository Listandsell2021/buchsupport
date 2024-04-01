<?php

namespace App\CommandProcess\Admin\Service;

use Rosamarsky\CommandBus\Command;

class GetFilteredServices implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
