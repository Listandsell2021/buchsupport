<?php

namespace App\CommandProcess\Admin\Product;

use Rosamarsky\CommandBus\Command;

class UpdateProductsBulkAction implements Command
{
    public array $productIds;
    public string $action;

    public function __construct(array $productIds, string $action)
    {
        $this->productIds = $productIds;
        $this->action = $action;
    }
}
