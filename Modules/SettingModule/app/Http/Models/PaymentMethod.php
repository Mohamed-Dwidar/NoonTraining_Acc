<?php

namespace Modules\SettingModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\CourseModule\app\Http\Models\CourseRegPayment;

/**
 * A payment method in the "طرق الدفع" list.
 * Soft deleted so old payments keep the name.
 */
class PaymentMethod extends Model
{
    use SoftDeletes;

    protected $table = 'payment_methods';

    protected $fillable = [
        'name',
        'is_active',
    ];

    function payments()
    {
        return $this->hasMany(CourseRegPayment::class, 'payment_method_id');
    }
}
