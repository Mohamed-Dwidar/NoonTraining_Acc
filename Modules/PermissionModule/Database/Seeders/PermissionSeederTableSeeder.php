<?php

namespace Modules\PermissionModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the guard name for roles and permissions
        $guardName = 'user';

        // Reset cached roles and permissions on each seed run
        app()['cache']->forget('spatie.permission.cache');

        // Create roles
        // $role = Role::create(['name' => 'moderator_role', 'guard_name' => $guardName]);
        

        // Create permissions
        $permission = Permission::create(['name' => 'Show Reports', 'guard_name' => $guardName]);


        // Assign permissions to the role
        // $role->givePermissionTo([
        //     $permission,
        // ]);
    }
}
