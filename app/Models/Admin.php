<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $table = "admin";
    protected $guard = 'admin';
    protected $fillable = ['name','email','password'];

    public function scopeGetListAdmin($query)
    {
        return $query->where("level", 1)->get();
    }
}
