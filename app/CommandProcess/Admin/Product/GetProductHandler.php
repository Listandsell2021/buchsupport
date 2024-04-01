<?php

namespace App\CommandProcess\Admin\Product;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\ProductService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetProductHandler implements Handler
{

    public ProductService $dbService;

    public function __construct(ProductService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getById($command->productId);
    }
}
