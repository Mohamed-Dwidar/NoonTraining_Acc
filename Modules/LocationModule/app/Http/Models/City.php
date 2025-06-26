<?php

namespace Modules\LocationModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'country_id', 'is_active'];
    public $timestamps = false;

    function country()
    {
        return $this->belongsTo(Country::class);
    }
}
