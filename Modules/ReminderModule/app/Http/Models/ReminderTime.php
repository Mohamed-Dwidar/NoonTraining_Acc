<?php

namespace Modules\ReminderModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A time the reminder appears at. before_minutes = 0 is the reminder date itself.
 */
class ReminderTime extends Model
{
    protected $table = 'reminder_times';

    protected $fillable = [
        'reminder_id',
        'before_minutes',
        'show_at',
    ];

    protected $casts = [
        'before_minutes' => 'integer',
        'show_at' => 'datetime',
    ];

    /** unit => [minutes, single, two, plural 3-10] (biggest first) */
    const UNITS = [
        'week' => [10080, 'أسبوع', 'أسبوعين', 'أسابيع'],
        'day' => [1440, 'يوم', 'يومين', 'أيام'],
        'hour' => [60, 'ساعة', 'ساعتين', 'ساعات'],
        'minute' => [1, 'دقيقة', 'دقيقتين', 'دقائق'],
    ];

    public function reminder()
    {
        return $this->belongsTo(Reminder::class);
    }

    public function reads()
    {
        return $this->hasMany(ReminderRead::class);
    }

    /** The time has come */
    public function scopeDue($query)
    {
        return $query->where('reminder_times.show_at', '<=', now());
    }

    public function scopeUnreadBy($query, Model $person)
    {
        return $query->whereDoesntHave('reads', function ($q) use ($person) {
            $q->by($person);
        });
    }

    /** before_minutes as [value, unit], e.g. 2880 → [2, 'day'] */
    public static function splitMinutes($minutes)
    {
        foreach (self::UNITS as $unit => $info) {
            if ($minutes >= $info[0] && $minutes % $info[0] == 0) {
                return [intdiv($minutes, $info[0]), $unit];
            }
        }
        return [0, 'minute'];
    }

    public static function beforeLabel($minutes)
    {
        if ($minutes == 0) {
            return 'في الموعد';
        }

        [$value, $unit] = self::splitMinutes($minutes);
        [, $single, $two, $plural] = self::UNITS[$unit];

        if ($value == 1)
            return 'قبل ' . $single;
        if ($value == 2)
            return 'قبل ' . $two;

        return 'قبل ' . $value . ' ' . ($value <= 10 ? $plural : $single);
    }

    public function getLabelAttribute()
    {
        return self::beforeLabel($this->before_minutes);
    }
}
