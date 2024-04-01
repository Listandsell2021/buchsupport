<?php

namespace App\CommandProcess\Admin\Dashboard;

use Rosamarsky\CommandBus\Command;

class GetSalespersonsCommissionGraph implements Command
{
    public array $salespersonIds;
    public string $dateFrom;
    public string $dateTo;

    public function __construct(array $salespersonIds, string $dateFrom, string $dateTo)
    {
        $this->salespersonIds = $salespersonIds;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
}
