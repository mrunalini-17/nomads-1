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
        Schema::create('booking_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->cascadeOnDelete();
            $table->text('service_details')->nullable();
            $table->date('travel_date1')->nullable();
            $table->date('travel_date2')->nullable();
            $table->decimal('gross_amount', 10, 2)->nullable();
            $table->string('confirmation_number')->nullable();
            $table->decimal('net', 10, 2)->nullable();
            $table->decimal('service_fees', 10, 2)->nullable();
            $table->decimal('mask_fees', 10, 2)->nullable(); // Mask fees
            $table->decimal('bill', 10, 2)->nullable(); // Bill amount
            $table->decimal('tcs', 10, 2)->nullable(); // TCS (Tax Collected at Source)
            $table->foreignId('card_id')->nullable()->constrained('cards')->cascadeOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->cascadeOnDelete();
            $table->enum('bill_to', ['self', 'company', 'other'])->nullable();
            $table->string('bill_to_remark')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('added_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps(); // Includes 'created_at' and 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_services');
    }
};
