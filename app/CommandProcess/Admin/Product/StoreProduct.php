<?php

namespace App\CommandProcess\Admin\Product;

use Rosamarsky\CommandBus\Command;

class StoreProduct implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
