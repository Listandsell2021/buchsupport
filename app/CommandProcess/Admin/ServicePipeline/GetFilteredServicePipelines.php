<?php

namespace App\CommandProcess\Admin\ServicePipeline;

use Rosamarsky\CommandBus\Command;

class GetFilteredServicePipelines implements Command
{
    public int $serviceId;
    public array $data;

    public function __construct(int $serviceId, array $data)
    {
        $this->serviceId = $serviceId;
        $this->data = $data;
    }
}
