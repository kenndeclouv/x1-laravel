<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'code' => 'superadmin',
            ],
            [
                'id' => 2,
                'name' => 'Admin',
                'code' => 'admin',
            ],
            [
                'id' => 3,
                'name' => 'User',
                'code' => 'user',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
