<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * The times a reminder appears at: its own date (before_minutes = 0) + "before 1 day", "before 2 days" ...
     */
    public function up(): void
    {
        Schema::create('reminder_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('reminder_id')->constrained('reminders')->cascadeOnDelete();
            $table->unsignedInteger('before_minutes')->default(0);
            // reminders.remind_at - before_minutes
            $table->dateTime('show_at')->index();
            $table->timestamps();

            $table->unique(['reminder_id', 'before_minutes']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_times');
    }
};
