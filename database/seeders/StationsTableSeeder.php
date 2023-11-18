<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Alexandria',
            'Assiut',
            'Aswan',
            'Beheira,',
            'Bani Suef',
            'Cairo',
            'Daqahliya',
            'Damietta',
            'Fayyoum',
            'Gharbiya',
            'Giza',
            'Helwan',
            'Ismailia',
            'Kafr El Sheikh',
            'Luxor',
            'Marsa Matrouh',
            'Minya',
            'Monofiya',
            'New Valley',
            'North Sinai',
            'Port Said',
            'Qalioubiya',
            'Qena',
            'Red Sea',
            'Sharqiya',
            'Sohag',
            'South Sinai',
            'Suez',
            'Tanta',
        ];

        foreach ($cities as $city) {
            DB::table('stations')->insert([
                'name' => $city,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
