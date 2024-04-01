<?php


namespace App\Libraries\DbMigrator;


use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\Membership;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomersMigrator
{
	use MigratorHelper;
	
	public static function execute($command)
	{
		User::truncate();
        $users = DB::connection('mysql2')->table('users')->select(
            'id as uid', 'first_name', 'last_name', 'address as street', DB::raw('CAST(zip AS UNSIGNED) as postal_code'), 'city', 'country', 'password', 'password_text','birth as dob', 'image_path', 'is_special', 'second_owner_first_name as secondary_first_name','second_owner_last_name as secondary_last_name', 'created_at', 'updated_at',
            DB::raw('(CASE 
            WHEN membership_id = 3 THEN "'.Membership::gold->name.'"
            WHEN membership_id = 2 THEN "'.Membership::silver->name.'"
            WHEN membership_id = 1 THEN "'.Membership::bronze->name.'"
            ELSE null
            END) AS membership'),
            DB::raw('(CASE 
            WHEN gender = "male" THEN "'.Gender::male->name.'"
            WHEN gender = "female" THEN "'.Gender::female->name.'"
            ELSE "other"
            END) AS gender')
        )
            ->where('is_admin', 0)
            ->get();

        foreach (array_chunk(self::toArray($users, ['is_active' => 1]), 50) as $chuckedUsers) {
    		User::insert($chuckedUsers);
        }

		$command->info('Users Seeded');
	}
	
}