<?php

namespace Modules\PermissionModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PermissionSeederTableSeeder::class);
        $this->call(RoleSeederTableSeeder::class);
    }
}
