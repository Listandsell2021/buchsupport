<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class GetLeadsMapLocation implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
