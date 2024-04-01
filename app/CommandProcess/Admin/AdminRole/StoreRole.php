<?php

namespace App\CommandProcess\Admin\AdminRole;

use Rosamarsky\CommandBus\Command;

class StoreRole implements Command
{
    public string $name;
    public int $status;
    public array $permissions;

    public function __construct(string $name, int $status, array $permissions)
    {
        $this->name = $name;
        $this->status = $status;
        $this->permissions = $permissions;
    }
}
