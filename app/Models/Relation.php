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
        'friend_id', 'type'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to get relations is unable to add friend
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeTypeNotFriendable($query)
    {
        $userTypes = ['friend', 'request'];
        $query->whereIn('type', $userTypes);
    }

    /**
     * Scope a query to get relations are requestions
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeTypeRequest($query)
    {
        $query->where('type', 'request');
    }
}
