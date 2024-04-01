<?php

namespace App\CommandProcess\Admin\ProductCategory;

use Rosamarsky\CommandBus\Command;

class UpdateCategory implements Command
{
    public int $categoryId;
    public array $data;

    public function __construct(int $categoryId, array $data)
    {
        $this->categoryId = $categoryId;
        $this->data = $data;
    }
}
