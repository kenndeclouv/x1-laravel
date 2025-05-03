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
                'name' => 'Elite',
                'description' => 'Dapatkan Dao Venerable dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 4',
                'price' => 1,
                'type' => 'rank',
                'period' => 30,
                'code'=> "elite"
            ],
            [
                'name' => 'Ascended',
                'description' => 'Dapatkan Dao Emperor dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 7 /itemname /enderchest',
                'price' => 2,
                'type' => 'rank',
                'period' => 30,
                'code'=> "ascended"
            ],
            [
                'name' => 'Mythical',
                'description' => 'Dapatkan Spiritual God dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 11 /itemname /enderchest /nick ',
                'price' => 3,
                'type' => 'rank',
                'period' => 30,
                'code'=> 'mythical'
            ],
            [
                'name' => 'Celestial',
                'description' => 'Dapatkan True God dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 16 /itemname /enderchest /nick /getpos /fly ',
                'price' => 4,
                'type' => 'rank',
                'period' => 30,
                'code'=> 'celestial'
            ],
            [
                'name' => 'Eternal',
                'description' => 'Dapatkan God Creator dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome unlimited /itemname /repair /enderchest /nick /getpos /fly /feed /god /tp player ',
                'price' => 5,
                'type' => 'rank',
                'period' => 30,
                'code'=> 'eternal'
            ],
            [
                'name' => '25K',
                'description' => 'Topup money 25K untuk gacha di dalam server',
                'price' => 1,
                'type' => 'money',
                'code'=> 25000
            ],
            [
                'name' => '50K',
                'description' => 'Topup money 50K untuk gacha di dalam server',
                'price' => 2,
                'type' => 'money',
                'code'=> 50000
            ],
            [
                'name' => '75K',
                'description' => 'Topup money 75K untuk gacha di dalam server',
                'price' => 3,
                'type' => 'money',
                'code'=> 75000
            ],
            [
                'name' => '100K',
                'description' => 'Topup money 100K untuk gacha di dalam server',
                'price' => 4,
                'type' => 'money',
                'code'=> 10000
            ],
        ];

        foreach ($items as $item) {
            Item::firstOrCreate($item);
        }
    }
}
