<?php

namespace Modules\ReminderModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A person (Admin | User) read a reminder time.
 */
class ReminderRead extends Model
{
    protected $table = 'reminder_reads';

    public $timestamps = false;

    protected $fillable = [
        'reminder_time_id',
        'reader_type',
        'reader_id',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function reader()
    {
        return $this->morphTo();
    }

    public function scopeBy($query, Model $person)
    {
        return $query->where('reader_type', $person->getMorphClass())
            ->where('reader_id', $person->getKey());
    }
}
