<?php

namespace App\CommandProcess\Admin\ProductCategory;

use App\Services\Admin\ProductCategoryService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateProductCategoriesBulkActionHandler implements Handler
{

    private ProductCategoryService $productCategoryService;

    public function __construct(ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

    public function handle(Command $command)
    {
        $message = '';

        if ($command->action == 'delete') {
            $this->productCategoryService->deleteBulk($command->productCategoryIds);
            $message = trans('Product categories deleted successfully');
        }

        if ($command->action == 'active') {
            $this->productCategoryService->updateBulkActiveStatus($command->productCategoryIds, 1);
            $message = trans('Product categories updated with status active successfully');
        }

        if ($command->action == 'inactive') {
            $this->productCategoryService->updateBulkActiveStatus($command->productCategoryIds, 0);
            $message = trans('Product categories updated with status inactive successfully');
        }

        return $message;
    }
}
