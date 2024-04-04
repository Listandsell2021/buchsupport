<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            AdminSeeder::class,
            SettingSeeder::class,
            MailSeeder::class,
            ServiceSeeder::class,
            CustomerSeeder::class,
            LeadStatusSeeder::class,
        ]);

        Artisan::call('import:prev_database');

        $this->call([
            SalespersonSeeder::class,
            LeadSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
