<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JsonException;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws JsonException
     */
    public function run(): void
    {
        DB::table('organizations')->insert([
            [
                'name' => 'ООО "Рога и Копыта"',
                'phone_numbers' => json_encode(['2-222-222', '3-333-333', '8-923-666-13-13'], JSON_THROW_ON_ERROR),
                'building_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ИП Иванов',
                'phone_numbers' => json_encode(['1-111-111', '4-444-444'], JSON_THROW_ON_ERROR),
                'building_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
