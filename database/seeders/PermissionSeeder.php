<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::firstOrCreate([
            'code' => 'all_feature',
            'name' => 'All Feature',
            'icon' => 'ti tabler-laurel-wreath',
        ]);
        $features = [
            // ['code' => 'user', 'icon' => 'ti ti-users'],
            ['code' => 'logviewer', 'icon' => 'ti tabler-file-description'],
            ['code' => 'foldertree', 'icon' => 'ti tabler-folder'],
            ['code' => 'routelist', 'icon' => 'ti tabler-list'],
            ['code' => 'performance', 'icon' => 'ti tabler-chart-bar'],
            ['code' => 'database', 'icon' => 'ti tabler-database'],
            ['code' => 'env', 'icon' => 'ti tabler-settings']
        ];

        foreach ($features as $feature) {
            $permissions = [
                "read_{$feature['code']}",
                "create_{$feature['code']}",
                "edit_{$feature['code']}",
                "delete_{$feature['code']}",
            ];

            foreach ($permissions as $code) {
                Permission::firstOrCreate([
                    'code' => $code,
                ], [
                    'name' => ucfirst(str_replace('_', ' ', str_replace('.', ' ', $code))),
                    'icon' => $feature['icon'],
                    'description' => "Permission for {$code}",
                ]);
            }
        }
    }
}
// namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Support\Facades\Route;
// use Illuminate\Database\Seeder;
// use App\Models\Permission;

// class PermissionSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run()
//     {
//         $permissions = [

//         ];

//         foreach ($permissions as $permission) {
//             if (!$permission) continue; // Skip route tanpa nama

//             $permissions = [
//                 "view_{$permission}",
//                 "create_{$permission}",
//                 "edit_{$permission}",
//                 "delete_{$permission}",
//             ];

//             foreach ($permissions as $code) {
//                 Permission::firstOrCreate([
//                     'code' => $code,
//                 ], [
//                     'name' => ucfirst(str_replace('_', ' ', str_replace('.', ' ', $code))),
//                     'icon' => 'ti ti-folder',
//                     'description' => "Permission for {$code}",
//                 ]);
//             }
//         }
//     }
// }
