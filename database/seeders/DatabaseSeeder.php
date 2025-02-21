<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeding data for departments
        DB::table('departments')->insert([
            ['department_name' => 'Customer Support', 'description' => 'Handles customer inquiries and support.', 'added_by' => 1, 'updated_by' => 1],
            ['department_name' => 'Finance', 'description' => 'Manages company finances and accounts.', 'added_by' => 1, 'updated_by' => 1],
            ['department_name' => 'Operations', 'description' => 'Responsible for tour and booking operations.', 'added_by' => 1, 'updated_by' => 1],
        ]);

        // Seeding data for sub_departments
        DB::table('sub_departments')->insert([
            ['department_id' => 1, 'name' => 'Inbound Support', 'added_by' => 1, 'updated_by' => 1],
            ['department_id' => 1, 'name' => 'Outbound Support', 'added_by' => 1, 'updated_by' => 1],
            ['department_id' => 2, 'name' => 'Accounts Receivable', 'added_by' => 1, 'updated_by' => 1],
            ['department_id' => 2, 'name' => 'Accounts Payable', 'added_by' => 1, 'updated_by' => 1],
            ['department_id' => 3, 'name' => 'Tour Planning', 'added_by' => 1, 'updated_by' => 1],
            ['department_id' => 3, 'name' => 'Booking Management', 'added_by' => 1, 'updated_by' => 1],
        ]);

        // Seeding data for designations
        DB::table('designations')->insert([
            ['designation_name' => 'Tour Manager', 'description' => 'Manages and oversees all tour operations.', 'added_by' => 1, 'updated_by' => 1],
            ['designation_name' => 'Customer Service Representative', 'description' => 'Handles customer service and inquiries.', 'added_by' => 1, 'updated_by' => 1],
            ['designation_name' => 'Accountant', 'description' => 'Manages financial records and transactions.', 'added_by' => 1, 'updated_by' => 1],
        ]);

        // Seeding data for user_roles
        DB::table('user_roles')->insert([
            ['name' => 'Admin', 'description' => 'Full access to all system functionalities.', 'is_active' => true, 'added_by' => 1, 'updated_by' => 1],
            ['name' => 'Employee', 'description' => 'Limited access based on department.', 'is_active' => true, 'added_by' => 1, 'updated_by' => 1],
            ['name' => 'Accounts', 'description' => 'Access to financial data and reports.', 'is_active' => true, 'added_by' => 1, 'updated_by' => 1],
        ]);
    }
}
