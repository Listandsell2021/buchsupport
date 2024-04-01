<?php

namespace App\CommandProcess\Admin\Customer;

use Rosamarsky\CommandBus\Command;

class SearchCustomers implements Command
{
    public array $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }
}
