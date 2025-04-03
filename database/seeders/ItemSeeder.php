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
                'type' => 'rank',
                'period' => 30,
                'code'=> "dao_venerable"
            ],
            [
                'name' => 'Dao Emperor',
                'description' => 'Dapatkan Dao Emperor dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 7 /itemname /enderchest',
                'price' => 20000,
                'type' => 'rank',
                'period' => 30,
                'code'=> "dao_emperor"
            ],
            [
                'name' => 'Spiritual God',
                'description' => 'Dapatkan Spiritual God dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 11 /itemname /enderchest /nick ',
                'price' => 35000,
                'type' => 'rank',
                'period' => 30,
                'code'=> 'dao_spiritual'
            ],
            [
                'name' => 'True God',
                'description' => 'Dapatkan True God dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome limit 16 /itemname /enderchest /nick /getpos /fly ',
                'price' => 45000,
                'type' => 'rank',
                'period' => 30,
                'code'=> 'true_god'
            ],
            [
                'name' => 'Immortal',
                'description' => 'Dapatkan God Creator dan dapatkan akses command /anvil /clear /pweather /wb /ptime /nv /hat /sethome unlimited /itemname /repair /enderchest /nick /getpos /fly /feed /god /tp player ',
                'price' => 60000,
                'type' => 'rank',
                'period' => 30,
                'code'=> 'immortal'
            ],
            [
                'name' => '25K',
                'description' => 'Topup money 25K untuk gacha di dalam server',
                'price' => 5000,
                'type' => 'money',
                'code'=> 25000
            ],
            [
                'name' => '50K',
                'description' => 'Topup money 50K untuk gacha di dalam server',
                'price' => 10000,
                'type' => 'money',
                'code'=> 50000
            ],
            [
                'name' => '75K',
                'description' => 'Topup money 75K untuk gacha di dalam server',
                'price' => 15000,
                'type' => 'money',
                'code'=> 75000
            ],
            [
                'name' => '100K',
                'description' => 'Topup money 100K untuk gacha di dalam server',
                'price' => 20000,
                'type' => 'money',
                'code'=> 100000
            ],
        ];

        foreach ($items as $item) {
            Item::firstOrCreate($item);
        }
    }
}
