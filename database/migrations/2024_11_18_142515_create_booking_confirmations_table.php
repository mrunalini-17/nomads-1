<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('booking_confirmations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('booking_service_id');
            $table->date('date')->nullable();
            $table->boolean('is_delivered')->default(false);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('booking_service_id')->references('id')->on('booking_services')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_confirmations');
    }
};
