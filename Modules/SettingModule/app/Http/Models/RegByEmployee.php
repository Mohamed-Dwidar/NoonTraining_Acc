<?php

namespace Modules\SettingModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\CourseModule\app\Http\Models\CourseReg;

/**
 * A name in the "تم التسجيل عن طريق" list.
 * Soft deleted so old registrations / reports keep the name.
 */
class RegByEmployee extends Model
{
    use SoftDeletes;

    protected $table = 'reg_by_employees';

    protected $fillable = [
        'name',
        'is_active',
    ];

    function courseRegs()
    {
        return $this->hasMany(CourseReg::class, 'reg_by_employee_id');
    }
}
