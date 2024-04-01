<?php

namespace Database\Seeders;

use App\DataHolders\Enum\AuthRole;
use App\DataHolders\Enum\Gender;
use App\Models\AdminPermission;
use App\Models\AdminRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        \App\Models\AdminRole::truncate();
        \App\Models\Admin::truncate();
        AdminPermission::truncate();

        $adminRole = AdminRole::create(['name' => 'Admin', 'is_active' => 1, 'default' => 1]);
        $employeeRole = AdminRole::create(['name' => 'Employee', 'is_active' => 1]);

        \App\Models\Admin::factory()->create([
            'first_name' => 'Dhan Kumar',
            'last_name' => 'Lama',
            'gender' => Gender::male->name,
            'auth_role' => AuthRole::getSuperAdminRole(),
            'role_id' => $adminRole->id,
            'email' => 'dhana@listandsell.de',
            'password' => bcrypt('password'),
            'is_active' => 1,
        ]);

        $roles = [$adminRole->id, $employeeRole->id];

        \App\Models\Admin::factory()->count(10)->create([
            'role_id' => $roles[array_rand($roles)]
        ]);

        $adminPermissions = array_map(function ($permission) use ($adminRole) {
            return ['role_id' => $adminRole->id, 'permission' => $permission];
        }, \App\DataHolders\Enum\AdminPermission::onlyNames());

        $employeePermissions = array_map(function ($permission) use ($employeeRole) {
            return ['role_id' => $employeeRole->id, 'permission' => $permission];
        }, \App\DataHolders\Enum\AdminPermission::onlyNames());

        \App\Models\AdminPermission::insert($adminPermissions);
        \App\Models\AdminPermission::insert($employeePermissions);

    }
}
