<?php

namespace App\Libraries\EloquentHelpers;

trait ProductHelper
{

    /**
     * Product with details
     *
     * @param $query
     * @param bool $hideHidden
     * @return void
     */
    public function scopeWithDetails($query, bool|int $hideHidden = true): void
    {
        $query->select([
            'products.id', 'products.id as product_id', 'products.name as product_name', 'products.description', 'products.youtube_link',
            'user_products.quantity', 'user_products.condition', 'user_products.position', 'user_products.purchased_date', 'user_products.price', 'user_products.status',
            'user_products.is_hidden as is_hidden',
            'user_products.note as user_product_note', 'user_products.id as user_product_id',
            'user_products.user_id', 'product_categories.name as category_name', 'products.category_id'
        ])
            ->with('images')
            ->join('user_products', 'products.id', 'user_products.product_id')
            ->leftJoin('product_categories', 'products.category_id', 'product_categories.id')
            ->where('user_products.status', 1);

        if ($hideHidden) {
            $query->where('user_products.is_hidden', 0);
        }
    }


}