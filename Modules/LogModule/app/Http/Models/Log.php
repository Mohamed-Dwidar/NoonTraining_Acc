<?php

namespace Modules\LogModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function userable()
    {
        return $this->morphTo();
    }

    public function scopeFilter($query, array $request)
    {
        // dd($request);
        //Filter By User
        if (isset($request['usr']) && $request['usr'] != 0) {
            if ($request['usr'] == 'admin')
                $query->where('userable_type', 'Modules\AdminModule\app\Http\Models\Admin');
            else
                $query->where('userable_id', $request['usr']);
        }

        // Filter By Branch (branch_id in user table)
        if (isset($request['brnch']) && $request['brnch'] != 0) {
            $query->whereHas('userable', function ($q) use ($request) {
                $q->where('branch_id', $request['brnch']);
            });
        }

        //Filter By Date From
        if (isset($request['dateRngFrm']) && $request['dateRngFrm'] != null) {
            $dateFrom = \DateTime::createFromFormat('d-m-Y', $request['dateRngFrm']);
            if ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom->format('Y-m-d'));
            }
        }

        //Filter By Date To
        if (isset($request['dateRngTo']) && $request['dateRngTo'] != null) {
            $dateTo = \DateTime::createFromFormat('d-m-Y', $request['dateRngTo']);
            if ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo->format('Y-m-d'));
            }
        }

        //Order Descending By Created At
        $query->orderBy('created_at', 'DESC');

        return $query;
    }
}
