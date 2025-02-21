<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        // Schema::create('followups', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('enquiry_id',20)->nullable();
        //     $table->text('remark')->nullable();
        //     $table->string('action')->nullable();
        //     $table->string('type')->nullable();
        //     $table->date('fdate')->nullable();
        //     $table->time('ftime')->nullable();
        //     $table->boolean('status')->default(false);
        //     $table->text('note')->nullable();
        //     $table->integer('updated_by')->nullable();
        //     $table->foreignId('added_by')->nullable()->constrained('employees')->onDelete('cascade');
        //     $table->boolean('is_deleted')->default(false);
        //     $table->timestamps();
        //});
    }

    public function down(): void
    {
        // Schema::dropIfExists('followups');
    }
};
