<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CardsTableSeeder extends Seeder
{
    /**
     * Seed the cards table.
     *
     * @return void
     */
    public function run()
    {
        // Insert multiple records into the cards table
        DB::table('cards')->insert([
            [
                'name' => 'Visa Classic',
                'number' => '4111111111111111',
                'comment' => 'Standard Visa card',
                'expiry_date' => '12/2025',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MasterCard Gold',
                'number' => '5500000000000004',
                'comment' => 'Premium MasterCard',
                'expiry_date' => '06/2026',
                'created_by' => 2,
                'updated_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'American Express',
                'number' => '378282246310005',
                'comment' => 'AMEX card',
                'expiry_date' => '09/2024',
                'created_by' => 3,
                'updated_by' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records as needed
        ]);
    }
}
