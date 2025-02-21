<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->call([
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
        ]);




        DB::table('user_roles')->insert([
            [
                'name' => 'Admin',
                'description' => 'Manages all departmnets, team and work flow.',
                'is_active' => true,
                'added_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager',
                'description' => 'Manages the department and team.',
                'is_active' => true,
                'added_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Accounts',
                'description' => 'Manages financial records and transactions.',
                'is_active' => true,
                'added_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Operations',
                'description' => 'Manages and oversees all operations.',
                'is_active' => true,
                'added_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);

        DB::table('employees')->insert([
            [
                'first_name' => "Nomad",
                'last_name' => "Admin",
                'mobile' => 8530055067,
                'whatsapp' => 8530055067,
                'email' => "admin@gmail.com",
                'password' => Hash::make(value: '123456'),
                'user_role_id' => 1,
                'is_superadmin' => 1,
                'is_active'  => 1,
                'added_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('permissions')->insert([
            'employee_id' => 1,
            'add' => 1,
            'edit' => 1,
            'update' => 1,
            'delete' => 1,
            'view' => 1,
            'is_deleted' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('cards')->insert([
            [
                'card_name' => 'Visa Classic',
                'card_number' => '4111111111111111',
                'description' => 'Standard Visa card',
                'expiry_date' => '12/2025',
                'added_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'card_name' => 'MasterCard Gold',
                'card_number' => '5500000000000004',
                'description' => 'Premium MasterCard',
                'expiry_date' => '06/2026',
                'added_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'card_name' => 'American Express',
                'card_number' => '378282246310005',
                'description' => 'AMEX card',
                'expiry_date' => '09/2024',
                'added_by' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records as needed
        ]);



    }
}
