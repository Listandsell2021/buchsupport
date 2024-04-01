<?php

namespace App\CommandProcess\Admin\Service;

use Rosamarsky\CommandBus\Command;

class UpdateService implements Command
{
    public int $serviceId;
    public array $data;

    public function __construct(int $serviceId, array $data)
    {
        $this->serviceId = $serviceId;
        $this->data = $data;
    }
}
