<?php

namespace App\CommandProcess\Admin\Product;


use App\Services\Admin\ProductService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateProductHandler implements Handler
{

    public ProductService $dbService;

    public function __construct(ProductService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->update($command->productId, $command->data);
    }
}
