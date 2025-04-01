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

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            ItemSeeder::class,
            StaffSeeder::class,
        ]);

        $superadmin->roles()->attach(1);
        $admin->roles()->attach(2);
        $user->roles()->attach(3);

        AppSetting::create([
            'app_color' => env('APP_COLOR', '#7367f0'),
            'app_theme' => env('APP_THEME', 'light'),
            'app_semidark' => env('APP_SEMIDARK', 1),
            'app_skin' => env('APP_SKIN', 0)
        ]);

        UserPermission::create([
            'user_id' => $superadmin->id,
            'permission_id' => 1
        ]);
    }
}
