<?php

namespace App\CommandProcess\Customer\Dashboard;

use App\Models\Product;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class FilterUserProductsHandler implements Handler
{

    public function handle(Command $command)
    {
        $productName = request()->get('search_key');
        $productConditions = (array) request()->get('conditions');
        $categoryIds = (array) request()->get('category_ids');
        $sortBy = $this->getSortingKey(request()->get('sort_column'), ['products.name', 'user_products.position', 'user_products.condition']);
        $sortOrder = $this->getSortOrder(request()->get('sort_order'));
        $paginationNo = request()->has('pagination_no') ? request()->get('pagination_no') : 12;

        $queryBuilder = Product::withDetails(0)
            ->where('user_products.user_id', $command->userId)
            ->where(function ($query) use ($productName, $productConditions, $categoryIds, $sortBy, $sortOrder) {
                if (!empty($productName)) {
                    $query->where('products.name', 'LIKE', '%' . $productName . '%');
                }
                if (count($categoryIds) > 0) {
                    $query->whereIn('products.category_id', $categoryIds);
                }
                if (count($productConditions) > 0) {
                    $query->whereIn('user_products.condition', $productConditions);
                }
            });

        if (!empty($sortBy)) {
            $queryBuilder->orderBy($sortBy, $sortOrder);
        }

        return $queryBuilder->paginate($paginationNo);;
    }

    /**
     * Get Sorting Key
     *
     * @param $key
     * @param $array
     * @return string
     */
    private function getSortingKey($key, $array): string
    {
        if (in_array($key, $array)) {
            return $key;
        }
        return '';
    }

    /**
     * Get Sort Order
     * @param $key
     * @param string $default
     * @return string
     */
    private function getSortOrder($key, string $default = 'asc'): string
    {
        if (in_array($key, ['asc', 'desc'])) {
            return $key;
        }
        return $default;
    }
}
