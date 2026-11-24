<?php

namespace Modules\ReminderModule\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\ReminderModule\app\Http\Models\Reminder;
use Modules\ReminderModule\app\Http\Models\ReminderRead;
use Prettus\Repository\Eloquent\BaseRepository;

class ReminderRepository extends BaseRepository
{
    function model()
    {
        return Reminder::class;
    }

    public function findAllWithFilter(array $request, Model $person, $perPage)
    {
        return Reminder::forPerson($person)
            ->filter($request, $person)
            ->withDetailsFor($person)
            ->orderBy('remind_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate($perPage);
    }

    /** Latest reminders whose time has come (header icon) */
    public function findLatest(Model $person, $limit)
    {
        return Reminder::forPerson($person)
            ->whereHas('times', function ($q) {
                $q->due();
            })
            ->withMax(['times as last_show_at' => function ($q) {
                $q->due();
            }], 'show_at')
            ->withDetailsFor($person)
            ->orderBy('last_show_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function countUnread(Model $person)
    {
        return Reminder::forPerson($person)->unreadBy($person)->count();
    }

    public function findOneVisible($id, Model $person)
    {
        return Reminder::forPerson($person)->withDetailsFor($person)->where('reminders.id', $id)->first();
    }

    /** $times: [before_minutes => show_at] */
    public function createWithTimes(array $data, array $times)
    {
        return DB::transaction(function () use ($data, $times) {
            $reminder = Reminder::create($data);
            $this->syncTimes($reminder, $times);
            return $reminder;
        });
    }

    /** $times: [before_minutes => show_at] */
    public function updateWithTimes(Reminder $reminder, array $data, array $times)
    {
        return DB::transaction(function () use ($reminder, $data, $times) {
            $reminder->update($data);
            $this->syncTimes($reminder, $times);
            return $reminder;
        });
    }

    /** Unchanged times keep their reads; a time that moved becomes unread again */
    private function syncTimes(Reminder $reminder, array $times)
    {
        $reminder->times()->whereNotIn('before_minutes', array_keys($times))->delete();

        $current = $reminder->times()->get()->keyBy('before_minutes');
        foreach ($times as $minutes => $showAt) {
            if (!isset($current[$minutes])) {
                $reminder->times()->create(['before_minutes' => $minutes, 'show_at' => $showAt]);
            } elseif (!$current[$minutes]->show_at->eq($showAt)) {
                $current[$minutes]->update(['show_at' => $showAt]);
                $current[$minutes]->reads()->delete();
            }
        }
    }

    /** Mark the times that have come as read by this person only (keeps the first read date) */
    public function markRead(Reminder $reminder, Model $person)
    {
        $rows = $reminder->times()->due()->unreadBy($person)->pluck('id')->map(function ($timeId) use ($person) {
            return [
                'reminder_time_id' => $timeId,
                'reader_type' => $person->getMorphClass(),
                'reader_id' => $person->getKey(),
                'read_at' => now()->format('Y-m-d H:i:s'),
            ];
        })->all();

        ReminderRead::insertOrIgnore($rows);
    }
}
