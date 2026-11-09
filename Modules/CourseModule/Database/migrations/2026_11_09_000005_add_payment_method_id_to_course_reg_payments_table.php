<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * "طريقة الدفع" → payment_methods.id (SettingModule).
     * The old enum column `pay_method` is kept for legacy rows.
     */
    public function up(): void
    {
        Schema::table('course_reg_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_method_id')->nullable()->after('pay_method');
            $table->index('payment_method_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_reg_payments', function (Blueprint $table) {
            $table->dropIndex(['payment_method_id']);
            $table->dropColumn('payment_method_id');
        });
    }
};
