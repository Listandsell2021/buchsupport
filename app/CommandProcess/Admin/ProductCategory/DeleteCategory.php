<?php

namespace App\CommandProcess\Admin\ProductCategory;

use Rosamarsky\CommandBus\Command;

class DeleteCategory implements Command
{
    public int $categoryId;

    public function __construct(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }
}
