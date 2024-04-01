<?php

namespace App\CommandProcess\Admin\Product;

use App\Services\Admin\ProductService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class SortProductImagesHandler implements Handler
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function handle(Command $command)
    {
        $this->productService->sortProductImages($command->imageIds);
    }
}
