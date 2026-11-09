<?php

namespace Modules\SettingModule\app\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class SettingAdminController extends Controller
{
    /**
     * إعدادات النظام — list of settings sections.
     */
    public function index()
    {
        return view('settingmodule::admin.index');
    }
}
