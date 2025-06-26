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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            // $table->morphs('logable');
            // $table->string('guard')->nullable();
            // $table->foreignId('user_id');
            // $table->text('message');

            $table->unsignedBigInteger('loggable_id');
            $table->string('loggable_type');
            $table->timestamp('login_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
