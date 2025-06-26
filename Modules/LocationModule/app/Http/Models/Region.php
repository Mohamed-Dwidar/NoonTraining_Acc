<?php

namespace Modules\LocationModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'country_id', 'city_id', 'is_active'];
    public $timestamps = false;

    function country()
    {
        return $this->belongsTo(Country::class);
    }

    function city()
    {
        return $this->belongsTo(City::class);
    }
}
