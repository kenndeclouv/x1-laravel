<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\User;
use App\Models\UserPermission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            ItemSeeder::class,
            StaffSeeder::class,
        ]);

        $superadmin = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => 'superadmin',
        ]);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
        ]);

        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => 'user',
        ]);

        $superadmin->roles()->attach(1);
        $admin->roles()->attach(2);
        $user->roles()->attach(3);

        AppSetting::create([
            'app_color' => '#7367f0',
            'app_theme' => 'light',
            'app_semidark' => 1,
            'app_skin' => 0
        ]);

        UserPermission::create([
            'user_id' => $superadmin->id,
            'permission_id' => 1
        ]);
    }
}
