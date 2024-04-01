<?php

namespace App\CommandProcess\Admin\Administrator;

use Rosamarsky\CommandBus\Command;

class UpdateAdminCommissionPaidStatus implements Command
{
    public int $commissionId;
    public int $paid;

    public function __construct(int $commissionId, int $paid)
    {
        $this->commissionId = $commissionId;
        $this->paid = $paid;
    }
}
