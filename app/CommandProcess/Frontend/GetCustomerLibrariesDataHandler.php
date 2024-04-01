<?php

namespace App\CommandProcess\Frontend;

use App\Libraries\HelperTraits\LibraryHelper;
use App\Models\UserProduct;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetCustomerLibrariesDataHandler implements Handler
{
    use LibraryHelper;


    public function handle(Command $command)
    {
        $productName = request()->input('product_name');
        $productCondition = request()->input('product_condition');
        $productCategories = (array) request()->input('product_categories');
        $sortBy = $this->getSortingKey(request()->input('sort_by'));
        $sortOrder = $this->getSortOrder(request()->input('sort_order'));

        $queryBuilder = $this->getProductWithDetails()
            ->where('user_products.user_id', $command->userId)
            ->where(function ($query) use ($productName, $productCondition, $productCategories, $sortBy, $sortOrder) {
                if (!empty($productName)) {
                    $query->where('products.title', 'LIKE', '%' . $productName . '%');
                }
                if (!empty($productCondition)) {
                    $query->where('user_products.condition', $productCondition);
                }
                if (count($productCategories) > 0) {
                    $query->whereIn('products.category_id', $productCategories);
                }
            });

        if (!empty($sortBy)) {
            $queryBuilder->orderBy($sortBy, $sortOrder);
        }

        $products = $queryBuilder->paginate(8);

        $productConditionAggregate = UserProduct::where('user_products.user_id', $command->userId)->avg('user_products.condition');

        $totalProducts = UserProduct::where('user_products.user_id', $command->userId)->sum('user_products.quantity');

        $categories = $this->searchProductCategoriesByUserId($command->userId)->get();

        return compact( 'products', 'totalProducts', 'categories', 'productConditionAggregate');
    }

    /**
     * Get Sorting Key
     *
     * @param $key
     * @return string
     */
    private function getSortingKey($key): string
    {
        if (in_array($key, ['products.title', 'user_products.condition', 'product_categories.title'])) {
            return $key;
        }
        return '';
    }

    /**
     * Get Sort Order
     * @param $key
     * @return string
     */
    private function getSortOrder($key): string
    {
        if (in_array($key, ['asc', 'desc'])) {
            return $key;
        }
        return '';
    }
}
