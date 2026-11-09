<?php

namespace Modules\SettingModule\Repository;

use Modules\SettingModule\app\Http\Models\RegByEmployee;
use Prettus\Repository\Eloquent\BaseRepository;

class RegByEmployeeRepository extends BaseRepository
{
    function model()
    {
        return RegByEmployee::class;
    }

    /** All names (admin list) with the number of registrations for each */
    public function findAllWithRegsCount()
    {
        return RegByEmployee::withCount('courseRegs')->orderBy('name')->get();
    }

    /** Active names only (for the dropdown) */
    public function findAllActive($columns = ['*'])
    {
        return RegByEmployee::where('is_active', 1)->orderBy('name')->get($columns);
    }

    public function findActiveOne($id)
    {
        return RegByEmployee::where('is_active', 1)->where('id', $id)->first();
    }

    public function findOneOrNull($id)
    {
        return RegByEmployee::where('id', $id)->first();
    }
}
