<?php

namespace App\CommandProcess\Admin\Product;

use App\Http\Resources\Admin\Product\ProductImageResource;
use App\Services\Admin\ProductService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetProductImagesHandler implements Handler
{
    private ProductService $dbService;

    public function __construct(ProductService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $productImages = $this->dbService->getProductImagesByProductId($command->productId);

        return ProductImageResource::collection($productImages);
    }
}
