<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Reminders ("الأشعارات") created by admins or users.
     */
    public function up(): void
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('details')->nullable();
            $table->dateTime('remind_at')->index();
            // 1 = all (admins + the creator's branch), 0 = the creator only
            $table->boolean('is_for_all')->default(0);
            // Admin | User
            $table->string('creator_type');
            $table->unsignedBigInteger('creator_id');
            // branch of the creator; null = created by admin (shared with all branches)
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['creator_type', 'creator_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
