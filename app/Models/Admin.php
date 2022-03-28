<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $table = "admin";
    protected $guard = 'admin';
    protected $fillable = ['name','email','password'];

    public function roles()
    {
        return $this->belongsToMany(Roles::class, "admin_role", "admin_id", "role_id");
    }

    public function checkPermissionAcess($keyCode)
    {
        $roles = Auth::guard("admin")->user()->roles;
        foreach ($roles as $role) {
            $permissions = $role->permissions;
            if ($permissions->contains("key_code", $keyCode)) {
                return true;
            }
        }
        return false;
    }
}
