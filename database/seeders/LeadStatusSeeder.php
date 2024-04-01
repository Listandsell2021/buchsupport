<?php

namespace Database\Seeders;


use App\Models\LeadStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        LeadStatus::truncate();

        $leadStatus = \App\DataHolders\Enum\LeadStatus::all();

        $data = [];
        $i = 1;
        foreach ($leadStatus as $key => $value) {
            $data[] = [
                'code' => $key,
                'name' => $value,
                'default' => $i === 1 ? 1 : 0,
                'created_at' => getCurrentDateTime(),
                'updated_at' => getCurrentDateTime(),
            ];
            ++$i;
        }

        LeadStatus::insert($data);

        Schema::enableForeignKeyConstraints();
    }

}
