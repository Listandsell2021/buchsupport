<?php

namespace App\Libraries\DbMigrator;


use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductImagesMigrator
{
	use MigratorHelper;
	
	public static function execute($command)
	{
		ProductImage::truncate();
        $products = DB::connection('mysql2')->table('product_images')->get();

        foreach (array_chunk(self::toArray($products), 50) as $chuckedProducts) {
    		ProductImage::insert($chuckedProducts);
        }

		$command->info('Product Images Seeded');
	}
	
}