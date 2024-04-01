<?php

namespace App\CommandProcess\Admin\ProductCategory;

use Rosamarsky\CommandBus\Command;

class UpdateCategoryActiveStatus implements Command
{
    public int $categoryId;
    public int $status;

    public function __construct(int $categoryId, int $status)
    {
        $this->categoryId = $categoryId;
        $this->status = $status;
    }
}
