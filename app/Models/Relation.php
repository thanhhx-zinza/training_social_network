<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'friend_id', 'type_user', 'type_friend'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to get relations is unable add friend
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeUnableAddFriendRelations($query)
    {
        $query->where('type_user', '!=', 'follow')->where('type_friend', '!=', 'decline');
    }

    /**
     * Scope a query to get users is unable add friend
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeGetRequestRelations($query)
    {
        $query->where('type_friend', 'response')->where('type_user', 'request');
    }
}
