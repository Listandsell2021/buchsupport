<?php

namespace App\CommandProcess\Admin\Lead;

use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetLeadAddedProductsHandler implements Handler
{

    public function handle(Command $command)
    {
        return DB::table('lead_new_products')
            ->select('lead_new_products.*', 'products.name as product_name', 'product_categories.name as category_name')
            ->leftJoin('products', function (JoinClause $join) {
                $join->on('lead_new_products.related_id', 'products.id')
                    ->where('lead_new_products.type', 'product');
            })
            ->leftJoin('product_categories', function (JoinClause $join) {
                $join->on('lead_new_products.related_id', 'product_categories.id')
                    ->where('lead_new_products.type', 'category');
            })
            ->where('lead_new_products.lead_id', $command->leadId)
            ->get();
    }
}
