<?php

namespace App\CommandProcess\Admin\ProductCategory;

use Rosamarsky\CommandBus\Command;

class StoreCategory implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
