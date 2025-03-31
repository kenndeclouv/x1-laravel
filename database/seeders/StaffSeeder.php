<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffs = [
            [
                'name' => 'PixyPAYCRAFT',
                'photo' => 'pixypaycraft.jpg',
                'role' => 'X1 Founder',
            ],
            [
                'name' => 'kenndeclouv',
                'photo' => 'kenndeclouv.png',
                'role' => 'Developer',
                'link' => 'https://kenndeclouv.my.id',
            ],
            [
                'name' => 'ItsukaArata',
                'photo' => 'itsukaarata.png',
                // 'role' => 'admin',
            ],
            [
                'name' => 'Vinn',
                'photo' => 'vinn.jpg',
                // 'role' => 'admin',
            ],
            [
                'name' => 'Rin',
                'photo' => 'rin.png',
                // 'role' => 'admin',
            ],
            [
                'name' => 'Rinne',
                'photo' => 'rinne.png',
                // 'role' => 'admin',
            ],
            [
                'name' => 'Rannkanaeru',
                'photo' => 'rannkanaeru.jpg',
                // 'role' => 'admin',
            ],


        ];

        foreach ($staffs as $staff) {
            Staff::firstOrCreate($staff);
        }
    }
}
