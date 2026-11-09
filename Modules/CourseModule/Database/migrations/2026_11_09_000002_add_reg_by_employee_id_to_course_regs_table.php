<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * "تم التسجيل عن طريق" → reg_by_employees.id (SettingModule).
     * The old text column `registered_by` is kept for legacy rows.
     */
    public function up(): void
    {
        Schema::table('course_regs', function (Blueprint $table) {
            $table->unsignedBigInteger('reg_by_employee_id')->nullable()->after('registered_by');
            $table->index('reg_by_employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_regs', function (Blueprint $table) {
            $table->dropIndex(['reg_by_employee_id']);
            $table->dropColumn('reg_by_employee_id');
        });
    }
};
