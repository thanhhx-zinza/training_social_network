<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class Reaction extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactiontable()
    {
        return $this->morphTo();
    }

    public function scopeOfType($query, $type)
    {
        $query->where('type', $type);
    }

    public function scopePostExists($query, $post_id)
    {
        return $query->post_id == $post_id;
    }

    public function scopeLikeUser($query, $user_id)
    {
        $query->where('user_id', $user_id);
    }

    public function scopeGetReactions($query, $reaction_table_id, $reaction_table_type)
    {
        $query->where('reactiontable_id', $reaction_table_id)->where('reactiontable_type', $reaction_table_type);
    }

    protected $fillable = [
        'user_id', 'reactiontable_id', 'reactiontable_type', 'type',
    ];

    public function notification()
    {
        return $this->morphOne(Notification::class, 'notifiable');
    }
}
