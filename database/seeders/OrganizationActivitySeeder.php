<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organization_activity')->insert([
            ['organization_id' => 1, 'activity_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['organization_id' => 1, 'activity_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['organization_id' => 2, 'activity_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['organization_id' => 2, 'activity_id' => 8, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
