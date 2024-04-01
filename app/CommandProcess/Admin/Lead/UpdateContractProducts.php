<?php

namespace App\CommandProcess\Admin\Lead;


use Rosamarsky\CommandBus\Command;

class UpdateContractProducts implements Command
{
    public int $contractId;
    public array $products;

    public function __construct(int $contractId, array $products)
    {
        $this->contractId = $contractId;
        $this->products = $products;
    }
}
