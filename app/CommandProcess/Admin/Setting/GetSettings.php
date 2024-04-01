<?php

namespace App\CommandProcess\Admin\Setting;

use Rosamarsky\CommandBus\Command;

class GetSettings implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
