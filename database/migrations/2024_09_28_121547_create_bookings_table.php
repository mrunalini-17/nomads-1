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
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('cascade');
            $table->foreignId('customer_manager_id')->nullable()->constrained('customer_managers')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->date('booking_date')->nullable();
            $table->integer('passenger_count')->default(1);
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->enum('status', ['Hold', 'Confirmed', 'Rebooked', 'Cancelled'])->nullable();
            // $table->enum('bill_to', ['self', 'company', 'other'])->nullable();
            // $table->string('bill_to_remark')->nullable();
            // $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->string('pan_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->enum('payment_status', ['instant', 'advance','credit'])->nullable();
            $table->text('payment_received_remark')->nullable(); // Adjusting for monetary value
            $table->timestamp('office_reminder')->nullable();
            $table->boolean('is_cancelled')->default(0);
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_accepted')->default(0);
            $table->foreignId('accepted_by')->nullable()->constrained('employees')->onDelete('cascade');
            $table->integer('updated_by')->nullable();
            $table->integer('added_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
