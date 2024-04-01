<?php

namespace App\CommandProcess\Admin\Service;

use Rosamarsky\CommandBus\Command;

class GetService implements Command
{
    public int $serviceId;

    public function __construct(int $serviceId)
    {
        $this->serviceId = $serviceId;
    }
}
