<?php

namespace App\CommandProcess\Admin\Product;

use Rosamarsky\CommandBus\Command;

class AddProductImage implements Command
{
    public int $productId;
    public mixed $image;

    public function __construct(int $productId, $image)
    {
        $this->productId = $productId;
        $this->image = $image;
    }
}
