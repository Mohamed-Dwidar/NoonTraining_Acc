<?php

namespace Modules\CourseModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\BranchModule\app\Http\Models\Branch;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{

    use SoftDeletes;
    // protected $guarded = [];
    protected $fillable = [
        'branch_id',
        'name',
        'group_nu',
        'course_org_nu',
        'start_at',
        'end_at',
        'price',
        'exam_fees',
        'is_available',
    ];

    function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['name'] . ' - ' . $this->attributes['group_nu'] . ' - ' . $this->attributes['course_org_nu'];
    }

    function courses_regs()
    {
        return $this->hasMany(CourseReg::class, 'course_id');
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


        if (isset($request['branch'])) {      //branch filter
            $query->where('branch_id', $request['branch']);
        }

        // "تم التسجيل عن طريق" filter: courses that have registrations by this employee ('none' = not set)
        if (!empty($request['regby'])) {
            $query->whereHas('courses_regs', function ($q) use ($request) {
                if ($request['regby'] == 'none') {
                    $q->whereNull('reg_by_employee_id');
                } else {
                    $q->where('reg_by_employee_id', $request['regby']);
                }
            });
        }

        // Date range filter on course start date (dateRngFrm / dateRngTo, yyyy-mm-dd).
        // start_at is a string column: mostly Y-m-d, some old rows d-m-Y.
        $startAtSql = "(CASE WHEN courses.start_at REGEXP '^[0-9]{4}-' THEN courses.start_at "
            . "ELSE DATE_FORMAT(STR_TO_DATE(courses.start_at, '%d-%m-%Y'), '%Y-%m-%d') END)";
        if (!empty($request['dateRngFrm'])) {
            $dateFrom = \DateTime::createFromFormat('Y-m-d', $request['dateRngFrm']);
            if ($dateFrom) {
                $query->whereRaw($startAtSql . ' >= ?', [$dateFrom->format('Y-m-d')]);
            }
        }
        if (!empty($request['dateRngTo'])) {
            $dateTo = \DateTime::createFromFormat('Y-m-d', $request['dateRngTo']);
            if ($dateTo) {
                $query->whereRaw($startAtSql . ' <= ?', [$dateTo->format('Y-m-d')]);
            }
        }

        if (isset($request['srch'])) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->orWhereRaw('UPPER(name) LIKE "%' . strtoupper($request['srch']) . '%"');
                $subQuery->orWhereRaw('UPPER(group_nu) LIKE "%' . strtoupper($request['srch']) . '%"');
                $subQuery->orWhereRaw('UPPER(course_org_nu) LIKE "%' . strtoupper($request['srch']) . '%"');
            });
        }


        if (isset($request['srt'])) {      //sort
            if ($request['srt'] == 'name_az') {
                $query->orderBy('courses.name', 'asc');
            } elseif ($request['srt'] == 'name_za') {
                $query->orderBy('courses.name', 'desc');
            } elseif ($request['srt'] == 'reg_az') {
                $query->orderBy('courses.created_at', 'asc');
            } elseif ($request['srt'] == 'reg_za') {
                $query->orderBy('courses.created_at', 'desc');
            }
        }

        return $query;
    }
}
