<?php

namespace App\CommandProcess\Admin\Product;

use Rosamarsky\CommandBus\Command;

class SortProductImages implements Command
{
    public array $imageIds;

    public function __construct(array $imageIds)
    {
        $this->imageIds = $imageIds;
    }
}
