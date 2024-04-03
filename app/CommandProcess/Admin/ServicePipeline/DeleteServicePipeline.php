<?php

namespace App\CommandProcess\Admin\ServicePipeline;

use Rosamarsky\CommandBus\Command;

class DeleteServicePipeline implements Command
{
    public int $serviceId;

    public function __construct(int $serviceId)
    {
        $this->serviceId = $serviceId;
    }
}
