<?php

namespace App\CommandProcess\Admin\AdminRole;

use Rosamarsky\CommandBus\Command;

class DeleteRole implements Command
{
    public int $roleId;

    public function __construct(int $roleId)
    {
        $this->roleId = $roleId;
    }
}
