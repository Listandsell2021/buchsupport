<?php

namespace App\CommandProcess\Admin\Product;

use App\Services\Admin\ProductService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateProductsBulkActionHandler implements Handler
{

    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function handle(Command $command)
    {
        $message = '';

        if ($command->action == 'delete') {
            $this->productService->deleteBulk($command->productIds);
            $message = trans('Products deleted successfully');
        }


        return $message;
    }
}
