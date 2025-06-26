<?php

namespace Modules\LocationModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name', 'code', 'currency', 'is_active'];
    protected $guarded = [];
    public $timestamps = false;

    function cities()
    {
        return $this->hasMany(City::class);
    }
}
