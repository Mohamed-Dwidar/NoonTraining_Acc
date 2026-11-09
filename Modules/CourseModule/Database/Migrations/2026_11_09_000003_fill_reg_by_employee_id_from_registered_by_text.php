<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Data migration: build the "تم التسجيل عن طريق" names list (reg_by_employees)
 * from the old free-text course_regs.registered_by, merging spelling variants,
 * and set course_regs.reg_by_employee_id.
 *
 * - Only rows with reg_by_employee_id = NULL are filled (manual choices are kept).
 * - Soft-deleted course_regs are included.
 * - The old text column is not changed.
 * - Values not listed here ("-", "المعهد", "حوالة", "570", empty ...) stay without an id.
 */
return new class extends Migration
{
    /** list name => old text variants (compared after TRIM) */
    private array $map = [
        'آلاء' => ['آلاء', 'الاء', 'أ. آلاء', 'ا/الاء'],
        'نايف' => ['ا نايف', 'أ. نايف', 'أ نايف', 'ا.نايف', 'أنايف', 'أ.نايف', 'انايف', 'نايف', 'ا نايف (إ)'],
        'يوسف' => ['يوسف', 'أ. يوسف', 'ا.يوسف', 'ا يوسف', 'أ.يوسف', 'بوسف'],
        'إسراء' => ['إسراء', 'اسراء'],
        'علي' => ['أ. علي', 'ا علي', 'أ علي', 'علي'],
        'ساره' => ['ساره'],
        'رميساء' => ['رميساء'],
        'إنجي' => ['إنجي'],
        'أوصاف' => ['أوصاف'],
    ];

    public function up(): void
    {
        DB::transaction(function () {
            foreach ($this->map as $name => $variants) {
                // reuse an existing (non-deleted) entry with the same name, else create it
                $id = DB::table('reg_by_employees')->where('name', $name)->whereNull('deleted_at')->value('id');
                if (!$id) {
                    $id = DB::table('reg_by_employees')->insertGetId([
                        'name' => $name,
                        'is_active' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('course_regs')
                    ->whereNull('reg_by_employee_id')
                    ->whereIn(DB::raw('TRIM(registered_by)'), $variants)
                    ->update(['reg_by_employee_id' => $id]);
            }
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            foreach ($this->map as $name => $variants) {
                $id = DB::table('reg_by_employees')->where('name', $name)->whereNull('deleted_at')->value('id');
                if (!$id) {
                    continue;
                }
                DB::table('course_regs')
                    ->where('reg_by_employee_id', $id)
                    ->whereIn(DB::raw('TRIM(registered_by)'), $variants)
                    ->update(['reg_by_employee_id' => null]);

                // remove the entry only if nothing else uses it
                if (!DB::table('course_regs')->where('reg_by_employee_id', $id)->exists()) {
                    DB::table('reg_by_employees')->where('id', $id)->delete();
                }
            }
        });
    }
};
