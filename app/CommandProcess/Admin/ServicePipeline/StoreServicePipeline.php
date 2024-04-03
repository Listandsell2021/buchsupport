<?php

namespace App\CommandProcess\Admin\ServicePipeline;

use Rosamarsky\CommandBus\Command;

class StoreServicePipeline implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
