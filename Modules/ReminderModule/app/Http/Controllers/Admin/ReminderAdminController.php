<?php

namespace Modules\ReminderModule\app\Http\Controllers\Admin;

use Modules\ReminderModule\app\Http\Controllers\ReminderController;

class ReminderAdminController extends ReminderController
{
    protected function portal()
    {
        return 'admin';
    }

    protected function creatorsForFilter()
    {
        return $this->reminderService->getCreatorsForFilter();
    }
}
