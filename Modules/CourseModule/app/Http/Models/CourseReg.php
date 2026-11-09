<?php

namespace Modules\CourseModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\StudentModule\app\Http\Models\Student;
use Modules\SettingModule\app\Http\Models\RegByEmployee;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseReg extends Model
{
    use SoftDeletes;
    // protected $guarded = [];
    protected $fillable = [
        'course_id',
        'student_id',
        'status_id',
        'main_price',
        'student_price',
        'price',
        'exam_fees',
        'is_free',
        'is_leave',
        'is_lawer',
        'coupon_id',
        'is_course_paid',
        'is_exam_paid',
        // 'is_nopaying',
        'is_recive_cert',
        'need_work_agree',
        'registered_by',
        'reg_by_employee_id',
    ];

    function student()
    {
        return $this->belongsTo(Student::class);
    }

    function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    function status()
    {
        return $this->belongsTo(CourseRegStatus::class, 'status_id');
    }

    function payments()
    {
        return $this->hasMany(CourseRegPayment::class)->orderBy('paid_at', 'asc');
    }

    function receipts()
    {
        return $this->hasMany(CourseRegReceipt::class);
    }

    /** "تم التسجيل عن طريق" — name from settings list (kept even if deleted from the list) */
    function regByEmployee()
    {
        return $this->belongsTo(RegByEmployee::class, 'reg_by_employee_id')->withTrashed();
    }

    /**
     * Name shown for "تم التسجيل عن طريق":
     * the selected name from the list, or the old free-text value for legacy rows.
     */
    public function getRegisteredByNameAttribute()
    {
        if ($this->reg_by_employee_id && $this->regByEmployee) {
            return $this->regByEmployee->name;
        }
        return $this->registered_by;
    }

    // Scopes
    /**
     * Filtering Courses
     *
     * @param Builder $query
     * @param array $request
     *
     * @return Builder
     */
    public function scopeFilter($query, $request)
    {
        // Join the courses and students tables
        $query->with(['student', 'course', 'regByEmployee']);

        // Branch filter
        if (!empty($request['branch'])) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('branch_id', $request['branch']);
            });
        }

        //course_id filter
        if (isset($request['course_id'])) {
            $query->where('course_id', $request['course_id']);
        }

        //status filter
        if (isset($request['fltr_sts'])) {
            if (is_array($request['fltr_sts'])) {
                $query->whereIN('status_id', $request['fltr_sts']);
            } else {
                $query->where('status_id', $request['fltr_sts']);
            }
        }

        //certificate filter
        if (isset($request['fltr_crt'])) {
            $query->where('is_recive_cert', $request['fltr_crt']);
        }

        // "تم التسجيل عن طريق" filter (regby = reg_by_employees.id, or 'none' = not set)
        if (!empty($request['regby'])) {
            if ($request['regby'] == 'none') {
                $query->whereNull('reg_by_employee_id');
            } else {
                $query->where('reg_by_employee_id', $request['regby']);
            }
        }

        //is_leave filter
        if (isset($request['fltr_leave'])) {
            $query->where('is_leave', $request['fltr_leave']);
        }

        // Search filter for students' name, phone1, and id_nu
        if (!empty($request['srch'])) {
            $searchTerm = strtoupper($request['srch']);
            $query->whereHas('student', function ($q) use ($searchTerm) {
                $q->whereRaw('UPPER(name) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('UPPER(phone1) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('UPPER(id_nu) LIKE ?', ["%{$searchTerm}%"]);
            });
        }
        return $query;
    }

    public function getDiscountAmountAttribute()
    {
        return $this->attributes['student_price'] - $this->attributes['price'];
        //return $this->attributes['student_price'] ==  $this->attributes['price'] ? 0 : round(100 - ($this->attributes['price'] / $this->attributes['student_price'] * 100));
    }

    public function getCoursePaidAmountAttribute()
    {
        return $this->hasMany(CourseRegPayment::class)->where('pay_type', 'دفعة للدورة')->sum('amount');
    }

    public function getExamPaidAmountAttribute()
    {
        return $this->hasMany(CourseRegPayment::class)->where('pay_type', 'رسوم الاختبار')->sum('amount');
    }

    // function coupon()
    // {
    //     return $this->belongsTo(Coupon::class);
    // }

    // function certificate()
    // {
    //     return $this->hasOne(Certificate::class);
    // }
}
