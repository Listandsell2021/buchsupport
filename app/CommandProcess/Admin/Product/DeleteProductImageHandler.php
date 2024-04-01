<?php

namespace App\CommandProcess\Admin\Product;

use App\Libraries\Services\ProductImageManager;
use App\Services\Admin\ProductService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteProductImageHandler implements Handler
{
    private ProductService $dbService;

    public function __construct(ProductService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $productImage = $this->dbService->getProductImageByImageId($command->imageId);
        ProductImageManager::deleteImageAndThumbnails($productImage->image_path);
        $this->dbService->deleteProductImage($command->imageId);
    }
}
