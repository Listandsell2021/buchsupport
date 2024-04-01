<?php

namespace App\CommandProcess\Admin\Product;

use Rosamarsky\CommandBus\Command;

class GetFilteredProducts implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
