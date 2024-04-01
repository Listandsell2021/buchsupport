<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class DeleteAddedProduct implements Command
{
    public int $addedProductId;

    public function __construct(int $addedProductId)
    {
        $this->addedProductId = $addedProductId;
    }
}
