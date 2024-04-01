<?php

namespace App\CommandProcess\Admin\Pipeline;

use Rosamarsky\CommandBus\Command;

class StorePipeline implements Command
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
