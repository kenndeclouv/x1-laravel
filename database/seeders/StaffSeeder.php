<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Str;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffs = [
            [
                'name' => 'Vinn',
                'photo' => 'vinn.jpg',
                'role' => 'Founder',
            ],
            [
                'name' => 'PixyPAYCRAFT',
                'photo' => 'pixypaycraft.jpg',
                'role' => 'Developer',
                'link' => 'https://instagram.com/pxclvr',
            ],
            [
                'name' => 'kenndeclouv',
                'photo' => 'kenndeclouv.png',
                'role' => 'Developer',
                'link' => 'https://kenndeclouv.my.id',
            ],
            [
                'name' => 'AkangHaise',
                'photo' => 'akanghaise.png',
                'role' => 'Inspector',
                'link' => 'https://instagram.com/maktanul',
            ],
            [
                'name' => 'Ririink',
                'photo' => 'ririink.png',
                'role' => 'Helper',
                'link' => 'https://instagram.com/vnist_sir',
            ],
            [
                'name' => 'Ratma_hikaru',
                'photo' => 'ratma_hikaru.png',
                'role' => 'Helper',
                'link' => 'https://tiktok.com/@rinnechhi_1',
            ],
            [
                'name' => 'Rannkanaeru',
                'photo' => 'rannkanaeru.jpg',
                'role' => 'Helper',
                'link' => 'https://instagram.com/rannkanaeru',
            ],
            [
                'name' => 'JumHzx',
                'photo' => 'jumhzx.png',
                'role' => 'Moderator',
                'link' => 'https://instagram.com/jumhzx',
            ],
            [
                'name' => 'Little_Craft6113',
                'photo' => 'little_craft6113.png',
                'role' => 'Helper',
                'link' => 'https://instagram.com/litte_craft6113',
            ],
            [
                'name' => 'Corvusion4249',
                'photo' => 'corvusion4249.png',
                'role' => 'Moderator',
                'link' => 'https://instagram.com/corpsiyon',
            ],
            [
                'name' => 'Finnlapox',
                'photo' => 'finnlapox.png',
                'role' => 'Moderator',
                'link' => 'https://instagram.com/finnhxh',
            ],
        ];

        foreach ($staffs as $staff) {
            Staff::firstOrCreate($staff);
            $user = User::firstOrCreate([
                'name' => $staff['name'],
                'email' => Str::lower($staff['name']) . '@x1.com',
                'password' => Str::upper($staff['name']),
            ]);

            $user->roles()->attach(3);
        }
    }
}
