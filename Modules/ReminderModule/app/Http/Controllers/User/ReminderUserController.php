<?php

namespace Modules\ReminderModule\app\Http\Controllers\User;

use Illuminate\Http\Request;
use Modules\ReminderModule\app\Http\Controllers\ReminderController;

class ReminderUserController extends ReminderController
{
    protected function portal()
    {
        return 'user';
    }

    /** Filter by user is for admin only */
    protected function filters(Request $request)
    {
        return $request->only(['sts']);
    }
}
