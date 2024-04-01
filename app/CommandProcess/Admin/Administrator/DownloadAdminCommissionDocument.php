<?php

namespace App\CommandProcess\Admin\Administrator;

use Rosamarsky\CommandBus\Command;

class DownloadAdminCommissionDocument implements Command
{
    public int $commissionId;

    public function __construct(int $commissionId)
    {
        $this->commissionId = $commissionId;
    }
}
