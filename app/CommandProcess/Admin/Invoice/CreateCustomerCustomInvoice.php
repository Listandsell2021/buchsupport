<?php

namespace App\CommandProcess\Admin\Invoice;

use Rosamarsky\CommandBus\Command;

class CreateCustomerCustomInvoice implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
