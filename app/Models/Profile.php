<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address',
        'gender',
        'birthday',
        'phone_number',
    ];

    private static $genders = ['male', 'female', 'other'];

    public function getGenders()
    {
        return self::$genders;
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
