<?php

namespace Modules\UserModule\app\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\BranchModule\app\Http\Models\Branch;
use Modules\LogModule\app\Http\Models\Log;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens, HasPermissions;

    protected $fillable = ['branch_id', 'name', 'email', 'password'];

    function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function givePermissions($permissions)
    {
        $this->syncPermissions($permissions);
    }

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'model', 'model_has_permissions', 'model_id', 'permission_id');
    }

    public function logable()
    {
        return $this->morphTo();
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }
}
