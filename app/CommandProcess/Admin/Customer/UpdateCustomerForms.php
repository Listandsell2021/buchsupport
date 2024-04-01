<?php

namespace App\CommandProcess\Admin\Customer;

use Rosamarsky\CommandBus\Command;

class UpdateCustomerForms implements Command
{
    public int $customerId;
    public array $forms;

    public function __construct(int $customerId, array $forms)
    {
        $this->customerId = $customerId;
        $this->forms = $forms;
    }
}
