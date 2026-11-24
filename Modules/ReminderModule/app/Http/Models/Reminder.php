<?php

namespace Modules\ReminderModule\app\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminModule\app\Http\Models\Admin;
use Modules\BranchModule\app\Http\Models\Branch;
use Modules\UserModule\app\Http\Models\User;

class Reminder extends Model
{
    use SoftDeletes;

    protected $table = 'reminders';

    protected $fillable = [
        'title',
        'details',
        'remind_at',
        'is_for_all',
        'creator_type',
        'creator_id',
        'branch_id',
    ];

    protected $casts = [
        'remind_at' => 'datetime',
        'is_for_all' => 'boolean',
    ];

    public function creator()
    {
        return $this->morphTo();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function times()
    {
        return $this->hasMany(ReminderTime::class)->orderBy('show_at');
    }

    /** Created by this person */
    public function scopeOwnedBy($query, Model $person)
    {
        return $query->where('reminders.creator_type', $person->getMorphClass())
            ->where('reminders.creator_id', $person->getKey());
    }

    /**
     * Reminders this person can see (page, header icon, read button):
     * admin → all, incl. users' private ones; user → their own + shared by their branch or by an admin.
     */
    public function scopeForPerson($query, Model $person)
    {
        if ($person instanceof Admin)
            return $query;

        return $query->where(function ($q) use ($person) {
            $q->where(function ($own) use ($person) {
                $own->ownedBy($person);
            })->orWhere(function ($shared) use ($person) {
                $shared->where('reminders.is_for_all', 1)
                    ->where(function ($branch) use ($person) {
                        $branch->whereNull('reminders.branch_id')
                            ->orWhere('reminders.branch_id', $person->branch_id);
                    });
            });
        });
    }

    /** Has a time that has come and this person didn't read it */
    public function scopeUnreadBy($query, Model $person)
    {
        return $query->whereHas('times', function ($q) use ($person) {
            $q->due()->unreadBy($person);
        });
    }

    /** Load what the views need: creator, times and only this person's reads */
    public function scopeWithDetailsFor($query, Model $person)
    {
        return $query->with([
            'creator',
            'branch',
            'times.reads' => function ($q) use ($person) {
                $q->by($person);
            },
        ]);
    }

    /** usr: "admin-{id}" | "user-{id}" , sts: unread | read | upcoming */
    public function scopeFilter($query, array $request, Model $person)
    {
        //Filter By User (creator)
        if (is_string($request['usr'] ?? null) && preg_match('/^(admin|user)-(\d+)$/', $request['usr'], $usr)) {
            $query->where('reminders.creator_type', $usr[1] == 'admin' ? (new Admin)->getMorphClass() : (new User)->getMorphClass())
                ->where('reminders.creator_id', $usr[2]);
        }

        //Filter By Status (for the logged in person)
        $status = $request['sts'] ?? null;
        if ($status == 'unread') {
            $query->unreadBy($person);
        } elseif ($status == 'read') {
            $query
                ->whereHas('times', function ($q) {
                    $q->due();
                })
                ->whereDoesntHave('times', function ($q) use ($person) {
                    $q->due()->unreadBy($person);
                });
        } elseif ($status == 'upcoming') {
            $query->whereDoesntHave('times', function ($q) {
                $q->due();
            });
        }

        return $query;
    }

    public function isOwnedBy(Model $person)
    {
        return $this->creator_type == $person->getMorphClass() && $this->creator_id == $person->getKey();
    }

    /** The creator and any admin */
    public function canBeManagedBy(Model $person)
    {
        return $person instanceof Admin || $this->isOwnedBy($person);
    }

    public function getDueTimesAttribute()
    {
        return $this->times->filter(function ($time) {
            return $time->show_at->lte(now());
        });
    }

    /** upcoming | unread | read — needs scopeWithDetailsFor (reads of one person) */
    public function getReadStatusAttribute()
    {
        if ($this->due_times->isEmpty())
            return 'upcoming';

        return $this->due_times->contains(function ($time) {
            return $time->reads->isEmpty();
        }) ? 'unread' : 'read';
    }

    /** Last time the person read it */
    public function getLastReadAtAttribute()
    {
        return $this->due_times->pluck('reads')->flatten()->max('read_at');
    }

    public function getAudienceLabelAttribute()
    {
        if (!$this->is_for_all)
            return 'خاص';
        if (is_null($this->branch_id))
            return 'الكل - جميع الفروع';

        return 'الكل - ' . ($this->branch->name ?? '---');
    }
}
