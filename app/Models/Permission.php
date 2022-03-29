<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    const PARENT_OF_PERMISSION = 0;
    protected $table = "permission";
    protected $fillable = ["name", "parent_id", "key_code"];

    public function childrent()
    {
        return $this->hasMany(Permission::class, "parent_id");
    }

    public function scopeGetParentOfPermission($query)
    {
        return $query->where("parent_id", self::PARENT_OF_PERMISSION)->get();
    }
}
