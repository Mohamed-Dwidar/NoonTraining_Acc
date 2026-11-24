<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Who read which reminder time, and when (each time has its own read state per person).
     */
    public function up(): void
    {
        Schema::create('reminder_reads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('reminder_time_id')->constrained('reminder_times')->cascadeOnDelete();
            // Admin | User
            $table->string('reader_type');
            $table->unsignedBigInteger('reader_id');
            $table->dateTime('read_at');

            $table->unique(['reminder_time_id', 'reader_type', 'reader_id'], 'reminder_reads_time_reader_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_reads');
    }
};
