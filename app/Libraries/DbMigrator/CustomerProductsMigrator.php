<?php


namespace App\Libraries\DbMigrator;


use App\Models\Service;
use App\Models\User;
use App\Models\UserService;
use Illuminate\Support\Facades\DB;

class CustomerProductsMigrator
{
	use MigratorHelper;
	
	public static function execute($command)
	{
		UserService::truncate();
        $userProducts = self::getUserProducts();

        foreach (array_chunk($userProducts, 50) as $chuckedUserProducts) {
    		UserService::insert($chuckedUserProducts);
        }

		$command->info('User Products Seeded');
	}

    public static function getUserProducts()
    {
        $userProducts = DB::connection('mysql2')->table('user_products')
            ->select('user_products.*')
            ->join('users', 'user_products.user_id', 'users.id')
            ->where('users.is_admin', 0)
            ->get();

        $users = User::select('id', 'uid')->get()->pluck('id', 'uid')->toArray();

        $data = [];
        foreach ($userProducts as $userProduct) {
            $userProduct->user_id = $users[$userProduct->user_id];
            $data[] = (array) $userProduct;
        }

        return $data;
    }
	
}