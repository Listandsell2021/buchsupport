<?php

namespace App\Console\Commands;

use App\Libraries\DbMigrator\CommentsMigrator;
use App\Libraries\DbMigrator\CustomerProductsMigrator;
use App\Libraries\DbMigrator\CustomersMigrator;
use App\Libraries\DbMigrator\ProductCategoriesMigrator;
use App\Libraries\DbMigrator\ProductImagesMigrator;
use App\Libraries\DbMigrator\ProductsMigrator;
use App\Libraries\DbMigrator\UserInquiriesMigrator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ImportPreviousDatabase extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:prev_database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Previous Database';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        Schema::disableForeignKeyConstraints();
        CustomersMigrator::execute($this);
        Schema::enableForeignKeyConstraints();
    }
}
