<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['customer_manager_id']);

            // Re-add the foreign key referencing 'customers' table
            $table->foreign('customer_manager_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Rollback: Drop the new constraint
            $table->dropForeign(['customer_manager_id']);

            // Re-add the old constraint referencing 'customer_managers'
            $table->foreign('customer_manager_id')->references('id')->on('customer_managers')->onDelete('cascade');
        });
    }
};
