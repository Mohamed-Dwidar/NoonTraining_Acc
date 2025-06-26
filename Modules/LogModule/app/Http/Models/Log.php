<?php

namespace Modules\LogModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AdminModule\app\Http\Models\Admin;
use Modules\UserModule\app\Http\Models\User;

class Log extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function loggable()
    {
        return $this->morphTo();
    }


    // Relations
    // public function user()
    // {
    //     return $this->morphMany(User::class, 'log');
    // }

    // Relations
    // public function admin()
    // {
    //     return $this->morphMany(Admin::class, 'log');
    // }
}
