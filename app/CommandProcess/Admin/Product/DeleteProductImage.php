<?php

namespace App\CommandProcess\Admin\Product;

use Rosamarsky\CommandBus\Command;

class DeleteProductImage implements Command
{
    public int $imageId;

    public function __construct(int $imageId)
    {
        $this->imageId = $imageId;
    }
}
