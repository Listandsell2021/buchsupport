<?php

namespace App\CommandProcess\Admin\Administrator;

use Rosamarsky\CommandBus\Command;

class UpdateAdminActiveStatus implements Command
{
    public int $adminId;
    public int $status;

    public function __construct(int $adminId, int $status)
    {
        $this->adminId = $adminId;
        $this->status = $status;
    }
}
