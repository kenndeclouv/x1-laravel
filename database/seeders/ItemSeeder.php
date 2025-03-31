<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Dao Venerable',
                'description' => 'Dapatkan Dao Venerable dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 4',
                'price' => 10000,
            ],
            [
                'name' => 'Dao Emperor',
                'description' => 'Dapatkan Dao Emperor dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 7 /itemname /enderchest',
                'price' => 20000,
            ],
            [
                'name' => 'Spiritual God',
                'description' => 'Dapatkan Spiritual God dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 11 /itemname /enderchest /nick ',
                'price' => 35000,
            ],
            [
                'name' => 'True God',
                'description' => 'Dapatkan True God dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 16 /itemname /enderchest /nick /getpos /fly ',
                'price' => 45000,
            ],
            [
                'name' => 'Immortal',
                'description' => 'Dapatkan God Creator dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome unlimited /itemname /repair /enderchest /nick /getpos /fly /feed /god /tp player ',
                'price' => 60000,
            ],
        ];

        foreach ($items as $item) {
            Item::firstOrCreate($item);
        }
    }
}
