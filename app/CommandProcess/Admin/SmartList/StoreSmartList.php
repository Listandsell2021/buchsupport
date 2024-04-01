<?php

namespace App\CommandProcess\Admin\SmartList;

use Rosamarsky\CommandBus\Command;

class StoreSmartList implements Command
{
    public string $name;
    public int $salespersonId;

    public function __construct(string $name, int $salespersonId)
    {
        $this->name = $name;
        $this->salespersonId = $salespersonId;
    }
}
