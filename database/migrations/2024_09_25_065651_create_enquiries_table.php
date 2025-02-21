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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('mobile',20)->nullable();
            $table->string('whatsapp',20)->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('source_id')->nullable()->constrained('sources')->nullOnDelete();
            $table->string('priority')->nullable();
            $table->json('services')->nullable();
            $table->json('employees')->nullable();
            $table->enum('status', ['New', 'Active', 'Converted', 'Dead'])->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_accepted')->default(false);
            $table->foreignId('accepted_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->integer('updated_by')->nullable();
            $table->integer('added_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
