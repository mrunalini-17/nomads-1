<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type'); // Type of notification (e.g., enquiry, booking)
            $table->unsignedBigInteger('type_id');
            $table->json('employees')->nullable();
            $table->string('message'); // Notification message
            $table->boolean('is_read')->default(false);
            $table->json('read_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
