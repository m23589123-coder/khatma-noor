<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            DB::table('juzs')->insert([
                'juz_number' => $i,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('khatmas')->insert([
            'total_completed' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
