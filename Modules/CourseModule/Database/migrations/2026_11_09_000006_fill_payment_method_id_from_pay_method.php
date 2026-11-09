<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Data migration: build the "طرق الدفع" list (payment_methods, SettingModule)
 * from the old enum values of course_reg_payments.pay_method,
 * and set course_reg_payments.payment_method_id.
 *
 * Needs the payment_methods table → run `php artisan module:migrate SettingModule` first.
 *
 * - Only rows with payment_method_id = NULL are filled.
 * - The old pay_method column is not changed.
 */
return new class extends Migration
{
    /** old enum values, in the order they appeared in the form */
    private array $methods = ['كاش', 'تحويل', 'شبكة', 'تابي', 'تمارا', 'يور واي', 'أخرى'];

    public function up(): void
    {
        DB::transaction(function () {
            foreach ($this->methods as $name) {
                // reuse an existing (non-deleted) entry with the same name, else create it
                $id = DB::table('payment_methods')->where('name', $name)->whereNull('deleted_at')->value('id');
                if (!$id) {
                    $id = DB::table('payment_methods')->insertGetId([
                        'name' => $name,
                        'is_active' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('course_reg_payments')
                    ->whereNull('payment_method_id')
                    ->where('pay_method', $name)
                    ->update(['payment_method_id' => $id]);
            }
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            foreach ($this->methods as $name) {
                $id = DB::table('payment_methods')->where('name', $name)->whereNull('deleted_at')->value('id');
                if (!$id) {
                    continue;
                }
                DB::table('course_reg_payments')
                    ->where('payment_method_id', $id)
                    ->where('pay_method', $name)
                    ->update(['payment_method_id' => null]);

                // remove the entry only if nothing else uses it
                if (!DB::table('course_reg_payments')->where('payment_method_id', $id)->exists()) {
                    DB::table('payment_methods')->where('id', $id)->delete();
                }
            }
        });
    }
};
