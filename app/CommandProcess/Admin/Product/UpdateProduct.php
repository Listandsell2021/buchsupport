<?php

namespace App\CommandProcess\Admin\Product;

use Rosamarsky\CommandBus\Command;

class UpdateProduct implements Command
{
    public int $productId;
    public array $data;

    public function __construct(int $productId, array $data)
    {
        $this->productId = $productId;
        $this->data = $data;
    }
}
