<?php


namespace App\Libraries\DbMigrator;


use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ProductsMigrator
{
	use MigratorHelper;
	
	public static function execute($command)
	{
		Service::truncate();
        $products = DB::connection('mysql2')->table('products')->select('id', 'title as name', 'category_id', 'note as description', 'yt_link as youtube_link', 'created_at', 'updated_at')->get();

        foreach (array_chunk(self::toArray($products), 50) as $chuckedProducts) {
    		Service::insert($chuckedProducts);
        }

		$command->info('Products Seeded');
	}
	
}