<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class UpdateLeadTablePreference implements Command
{
    public array $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }
}
