<?php

namespace App\CommandProcess\Admin\Product;


use App\Libraries\Services\ProductImageManager;
use App\Services\Admin\ProductService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteProductHandler implements Handler
{

    private ProductService $dbService;

    /**
     * @param ProductService $dbService
     */
    public function __construct(ProductService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $product = $this->dbService->getById($command->productId);

        if ($product) {
            ProductImageManager::deleteFolder($product->id);

            $this->dbService->delete($command->productId);
        }

    }
}
