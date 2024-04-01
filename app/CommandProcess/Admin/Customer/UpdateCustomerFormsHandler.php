<?php

namespace App\CommandProcess\Admin\Customer;


use App\Helpers\Trait\ProductAttributes;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateCustomerFormsHandler implements Handler
{
    use ProductAttributes;

    public function handle(Command $command)
    {
        $this->updateUserProducts($command->customerId, $command->forms);
    }
}
