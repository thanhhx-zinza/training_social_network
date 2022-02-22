<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function relations()
    {
        return $this->hasMany(Relation::class, 'user_id');
    }

    public function relationsFriend()
    {
        return $this->hasMany(Relation::class, 'friend_id');
    }

    /**
     * Check user is exist in db or not
     *
     */
    public function isExistUser($id)
    {
        return self::find($id);
    }

    /**
     * Check user is able to add friend or not
     *
     */
    public function isFriendable($id)
    {
        $user = self::isExistUser($id);
        if ($user != null) {
            if ($user->is_added != 1 || $user->id == $this->id) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Scope a query to get only user is able to add friend
     *
     */
    public function scopeFriendable($query, $id)
    {
        $query->where('id', '!=', $id)->where('is_added', 1);
    }
}
