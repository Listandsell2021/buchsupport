<?php


namespace App\Libraries\DbMigrator;


use App\Models\CallUser;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserInquiriesMigrator
{
    use MigratorHelper;

    public static function execute($command)
    {
        CallUser::truncate();
        $data = DB::connection('mysql2')->table('call_users')->select('*')->get()->toArray();

        $userInquiries = [];
        foreach ($data as $row) {
            $userInquiries[] = Arr::only((array) $row, array_merge(CallUser::fillableProps(), ['id', 'created_at', 'updated_at']));
        }
        foreach ($userInquiries as $inquiry) {
            if ($inquiry['user_id'] && is_int($inquiry['user_id'])) {
                $user = User::where('uid', $inquiry['user_id'])->first();
                if ($user) {
                    $inquiry['user_id'] = $user->id;
                }
            }
            CallUser::create($inquiry);
        }


        $command->info('User inquiries Seeded');
    }

}
