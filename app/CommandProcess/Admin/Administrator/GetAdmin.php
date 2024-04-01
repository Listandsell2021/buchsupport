<?php

namespace App\CommandProcess\Admin\Administrator;

use Rosamarsky\CommandBus\Command;

class GetAdmin implements Command
{
    public int $adminId;

    public function __construct(int $adminId)
    {
        $this->adminId = $adminId;
    }
}
