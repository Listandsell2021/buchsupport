<?php

namespace App\CommandProcess\Customer\Dashboard;

use App\Models\ProductCategory;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetUserProductCategoriesHandler implements Handler
{

    public function handle(Command $command)
    {
        return ProductCategory::select('product_categories.*')
            ->join('products', 'product_categories.id', 'products.category_id')
            ->join('user_products', 'products.id', 'user_products.product_id')
            ->where('user_products.user_id', $command->userId)
            ->groupBy('product_categories.id')
            ->get();
    }
}
