<?php

namespace Modules\PermissionModule\Repository;


use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository
{
    function model()
    {
        return Permission::class;
    }

    // function filter($request)
    // {
    //     return Permission::filter($request);
    // }

}
