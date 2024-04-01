<?php

namespace Database\Seeders;

use App\DataHolders\Enum\AuthRole;
use App\DataHolders\Enum\Gender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SalespersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        \App\Models\Admin::factory()->count(10)->create([
            'auth_role' => AuthRole::getSalespersonRole(),
        ]);
        \App\Models\Admin::factory()->create([
            'first_name' => 'Vishal',
            'last_name' => 'Rana',
            'gender' => Gender::male->name,
            'auth_role' => AuthRole::getSalespersonRole(),
            'email' => 'vishal@listandsell.de',
            'password' => bcrypt('password'),
            'is_active' => 1,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
