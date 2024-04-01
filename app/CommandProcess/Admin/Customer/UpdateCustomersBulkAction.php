<?php

namespace App\CommandProcess\Admin\Customer;

use Rosamarsky\CommandBus\Command;

class UpdateCustomersBulkAction implements Command
{
    public array $customerIds;
    public string $action;

    public function __construct(array $customerIds, string $action)
    {
        $this->customerIds = $customerIds;
        $this->action = $action;
    }
}
