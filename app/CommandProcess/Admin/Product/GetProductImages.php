<?php

namespace App\CommandProcess\Admin\Product;

use Rosamarsky\CommandBus\Command;

class GetProductImages implements Command
{
    public int $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }
}