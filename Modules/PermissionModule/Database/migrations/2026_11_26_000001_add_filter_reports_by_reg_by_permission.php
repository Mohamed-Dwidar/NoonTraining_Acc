<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Permission "فلتر التقارير بالموظفين": the employee can filter reports by "تم التسجيل عن طريق".
     * User create/edit forms send the permission id (value="8") — check it matches after migrating.
     */
    public function up(): void
    {
        Permission::firstOrCreate(['name' => 'filter_reports_by_reg_by', 'guard_name' => 'user']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'filter_reports_by_reg_by')->where('guard_name', 'user')->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
