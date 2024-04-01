<?php

namespace App\CommandProcess\Admin\Administrator;

use Rosamarsky\CommandBus\Command;

class GetFilteredAdmins implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
