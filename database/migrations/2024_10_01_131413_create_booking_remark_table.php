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
        Schema::create('booking_remark', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('remark_type')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_acknowledged')->default(false);
            $table->boolean('is_shareable')->default(true);
            $table->unsignedInteger('acknowledged_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('added_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_remark');
    }
};
