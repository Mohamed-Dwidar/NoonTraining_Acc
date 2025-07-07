<?php

namespace Modules\StudentModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\BranchModule\app\Http\Models\Branch;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\CourseModule\app\Http\Models\CourseReg;
use Modules\CourseModule\app\Http\Models\CourseRegPayment;
use Modules\LocationModule\app\Http\Models\City;

class Student extends Model
{
    use SoftDeletes;
    // protected $guarded = [];
    protected $fillable = [
        'name',
        'branch_id',
        'id_nu',
        'phone1',
        'phone2',
        'city_id',
        'company',
        'email',
        'birthdate',
        'id_expire_date',
        'nationality',
        'gender',
        'notes'
    ];

    function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    function city()
    {
        return $this->belongsTo(City::class);
    }

    function courses_regs()
    {
        return $this->hasMany(CourseReg::class, 'student_id');
    }

    function payments()
    {
        return $this->hasMany(CourseRegPayment::class, 'student_id');
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
        // dd($request);

        // if (isset($request['srch'])) {      //certificate filter
        //     $query->where('is_recive_cert', $request['fltr_crt']);
        // }

        if (isset($request['branch'])) {      //branch filter
            $query->where('branch_id', $request['branch']);
        }


        if (isset($request['srch'])) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->orWhereRaw('UPPER(name) LIKE "%' . strtoupper($request['srch']) . '%"');
                $subQuery->orWhereRaw('UPPER(phone1) LIKE "%' . strtoupper($request['srch']) . '%"');
                $subQuery->orWhereRaw('UPPER(id_nu) LIKE "%' . strtoupper($request['srch']) . '%"');
            });
        }


        if (isset($request['srch'])) {
            // $query->where('name', 'like', '%' . $request['srch'] . '%');

            // $query->where(function ($subQuery) use ($request) {
            //     $subQuery->whereHas('student', function ($subQuery) use ($request) {
            //         $subQuery->where('name', 'like', '%' . $request['srch'] . '%');
            //     });
            // });
        }


        if (isset($request['srt'])) {      //sort
            if ($request['srt'] == 'name_az') {
                $query->orderBy('students.name', 'asc');
            } elseif ($request['srt'] == 'name_za') {
                $query->orderBy('students.name', 'desc');
            } elseif ($request['srt'] == 'reg_az') {
                $query->orderBy('students.created_at', 'asc');
            } elseif ($request['srt'] == 'reg_za') {
                $query->orderBy('students.created_at', 'desc');
            }
        }

        return $query;
    }
}
