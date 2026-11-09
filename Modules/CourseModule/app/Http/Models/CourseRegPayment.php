<?php

namespace Modules\CourseModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\SettingModule\app\Http\Models\PaymentMethod;
use Modules\StudentModule\app\Http\Models\Student;

class CourseRegPayment extends Model
{
    // protected $guarded = [];
    protected $fillable = [
        'course_reg_id',
        'student_id',
        'pay_method',
        'payment_method_id',
        'amount',
        'paid_at',
        'pay_type'
    ];

    // payment method name is shown wherever payments are listed
    protected $with = ['paymentMethod'];
    
    function student()
    {
        return $this->belongsTo(Student::class);
    }

    function courseReg()
    {
        return $this->belongsTo(CourseReg::class);
    }

    /** "طريقة الدفع" from the SettingModule list (incl. soft-deleted, so old payments keep the name) */
    function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id')->withTrashed();
    }

    /** Display name: list name, or the old enum text for rows without an id */
    public function getPaymentMethodNameAttribute()
    {
        return $this->paymentMethod->name ?? $this->pay_method;
    }
}
