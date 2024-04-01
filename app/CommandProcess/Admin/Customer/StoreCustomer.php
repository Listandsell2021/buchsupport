<?php

namespace App\CommandProcess\Admin\Customer;

use Rosamarsky\CommandBus\Command;

class StoreCustomer implements Command
{
    public array $data;
    public array $forms;

    public function __construct(array $data, array $forms)
    {
        $this->data = $data;
        $this->forms = $forms;
    }
}
