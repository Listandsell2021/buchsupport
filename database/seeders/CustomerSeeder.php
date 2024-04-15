<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //\App\Models\User::truncate();

        \App\Models\User::factory()->create([
            'first_name' => 'Dhan Kumar',
            'last_name' => 'Lama',
            'email' => 'dhana@listandsell.de',
            'is_active' => 1,
        ]);

        //\App\Models\User::factory()->count(1000)->create();
    }
}
