<?php

namespace App\CommandProcess\Admin\Customer;

use Rosamarsky\CommandBus\Command;

class GetCustomerDocumentPdf implements Command
{
    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
