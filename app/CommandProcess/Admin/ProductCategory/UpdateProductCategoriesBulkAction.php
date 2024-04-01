<?php

namespace App\CommandProcess\Admin\ProductCategory;

use Rosamarsky\CommandBus\Command;

class UpdateProductCategoriesBulkAction implements Command
{
    public array $productCategoryIds;
    public string $action;

    public function __construct(array $productCategoryIds, string $action)
    {
        $this->productCategoryIds = $productCategoryIds;
        $this->action = $action;
    }
}
