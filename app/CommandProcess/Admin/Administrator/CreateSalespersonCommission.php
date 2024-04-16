<?php

namespace App\CommandProcess\Admin\Administrator;

use Rosamarsky\CommandBus\Command;

class CreateSalespersonCommission implements Command
{
    public int $adminId;
    public string $dateFrom;
    public string $dateTo;

    public function __construct(int $adminId, string $dateFrom, string $dateTo)
    {
        $this->adminId = $adminId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
}
