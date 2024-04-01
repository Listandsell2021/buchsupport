<?php

namespace App\CommandProcess\Admin\Service;

use Rosamarsky\CommandBus\Command;

class UpdateServiceActiveStatus implements Command
{
    public int $serviceId;
    public int $status;

    public function __construct(int $serviceId, int $status)
    {
        $this->serviceId = $serviceId;
        $this->status = $status;
    }
}
