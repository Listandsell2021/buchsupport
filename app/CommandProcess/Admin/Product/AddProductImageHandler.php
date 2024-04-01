<?php

namespace App\CommandProcess\Admin\Product;


use App\Libraries\Services\ProductImageManager;
use App\Services\Admin\ProductService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class AddProductImageHandler implements Handler
{
    private ProductService $dbService;

    public function __construct(ProductService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $imagePath = ProductImageManager::store($command->productId, $command->image, $command->image->getClientOriginalName());
        $this->dbService->createProductImage((int) $command->productId, (string) $command->image->getClientOriginalName(), $imagePath);
    }
}
