<?php


namespace App\Libraries\DbMigrator;


use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class ProductCategoriesMigrator
{
	use MigratorHelper;
	
	public static function execute($command)
	{
		ProductCategory::truncate();
        $categories = DB::connection('mysql2')->table('product_categories')->select('id', 'title as name', 'created_at', 'updated_at')->get();
		ProductCategory::insert(self::toArray($categories, ['is_active' => 1]));
		
		$command->info('Product Categories Seeded');
	}
	
}