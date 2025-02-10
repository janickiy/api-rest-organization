<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('buildings')->insert([
            [
                'address' => 'г. Москва, ул. Ленина 1, офис 3',
                'latitude' => 55.7558,
                'longitude' => 37.6173,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'address' => 'г. Новосибирск, ул. Блюхера 32/1',
                'latitude' => 55.0415,
                'longitude' => 82.9346,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
