<?php


namespace App\Libraries\DbMigrator;


use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentsMigrator
{
    use MigratorHelper;

    public static function execute($command)
    {
        Comment::truncate();
        $data = DB::connection('mysql2')->table('comments')->select('*')->get();

        $comments = [];
        foreach ($data as $row) {
            $row->user_id = User::where('uid', $row->user_id)->first()->id;
            $comments[] = (array) $row;
        }

        Comment::insert($comments);

        $command->info('Comments Seeded');
    }

}
