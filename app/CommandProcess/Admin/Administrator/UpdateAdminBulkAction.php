<?php

namespace App\CommandProcess\Admin\Administrator;

use Rosamarsky\CommandBus\Command;

class UpdateAdminBulkAction implements Command
{
    public array $adminIds;
    public string $action;

    public function __construct(array $adminIds, string $action)
    {
        $this->adminIds = $adminIds;
        $this->action = $action;
    }
}
