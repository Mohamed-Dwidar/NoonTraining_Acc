<?php

namespace Modules\ReminderModule\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\AdminModule\app\Http\Models\Admin;
use Modules\AdminModule\Services\AdminService;
use Modules\ReminderModule\app\Http\Models\Reminder;
use Modules\ReminderModule\app\Http\Models\ReminderTime;
use Modules\ReminderModule\Repository\ReminderRepository;
use Modules\UserModule\Services\UserService;

class ReminderService
{
    private $reminderRepository;
    private $userService;
    private $adminService;

    public function __construct(ReminderRepository $reminderRepository, UserService $userService, AdminService $adminService)
    {
        $this->reminderRepository = $reminderRepository;
        $this->userService = $userService;
        $this->adminService = $adminService;
    }

    public function findAllWithFilter(array $request, Model $person, $perPage = 20)
    {
        return $this->reminderRepository->findAllWithFilter($request, $person, $perPage);
    }

    public function findLatest(Model $person, $limit = 8)
    {
        return $this->reminderRepository->findLatest($person, $limit);
    }

    /** Unread reminders of this person (admin: all reminders) */
    public function countUnread(Model $person)
    {
        return $this->reminderRepository->countUnread($person);
    }

    /** Null when it doesn't exist or this person can't see it */
    public function findOneVisible($id, Model $person)
    {
        return $this->reminderRepository->findOneVisible($id, $person);
    }

    /** Options of the admin "user" filter: value => name */
    public function getCreatorsForFilter()
    {
        $creators = [];
        foreach ($this->adminService->findAll() as $admin) {
            $creators['admin-' . $admin->id] = $admin->name;
        }
        foreach ($this->userService->findAll()->load('branch') as $user) {
            $creators['user-' . $user->id] = $user->name . ' - ' . ($user->branch->name ?? '---');
        }
        return $creators;
    }

    public function create($data, Model $person)
    {
        $reminderData = $this->reminderData($data);
        $reminderData['creator_type'] = $person->getMorphClass();
        $reminderData['creator_id'] = $person->getKey();
        // null means all branches, so a user must never get null
        $reminderData['branch_id'] = $person instanceof Admin ? null : (int) $person->branch_id;

        return $this->reminderRepository->createWithTimes($reminderData, $this->buildTimes($data));
    }

    /** Creator and branch never change (admin can edit a user's reminder) */
    public function update(Reminder $reminder, $data)
    {
        return $this->reminderRepository->updateWithTimes($reminder, $this->reminderData($data), $this->buildTimes($data));
    }

    public function deleteOne($id)
    {
        return $this->reminderRepository->delete($id);
    }

    public function markRead(Reminder $reminder, Model $person)
    {
        $this->reminderRepository->markRead($reminder, $person);

        return $this->reminderRepository->findOneVisible($reminder->id, $person);
    }

    /**
     * Labels of the chosen times that already passed.
     * On edit, times that didn't change are allowed (they already appeared).
     */
    public function findPastTimes($data, ?Reminder $reminder = null)
    {
        $current = $reminder ? $reminder->times->keyBy('before_minutes') : collect();

        $past = [];
        foreach ($this->buildTimes($data) as $minutes => $showAt) {
            $unchanged = isset($current[$minutes]) && $current[$minutes]->show_at->eq($showAt);
            if (!$unchanged && $showAt->lt(now())) {
                $past[] = ReminderTime::beforeLabel($minutes) . ' (' . $showAt->format('Y-m-d H:i') . ')';
            }
        }
        return $past;
    }

    private function reminderData($data)
    {
        return [
            'title' => trim($data->title),
            'details' => $data->details,
            'remind_at' => $this->remindAt($data),
            'is_for_all' => $data->is_for_all ? 1 : 0,
        ];
    }

    private function remindAt($data)
    {
        return Carbon::createFromFormat('Y-m-d H:i', $data->remind_date . ' ' . $data->remind_time)->startOfMinute();
    }

    /** [before_minutes => show_at]; always has the reminder date itself (0) */
    private function buildTimes($data)
    {
        $remindAt = $this->remindAt($data);

        $times = [0 => $remindAt];
        foreach ((array) $data->before as $before) {
            $minutes = (int) $before['value'] * ReminderTime::UNITS[$before['unit']][0];
            $times[$minutes] = $remindAt->copy()->subMinutes($minutes);
        }
        return $times;
    }
}
