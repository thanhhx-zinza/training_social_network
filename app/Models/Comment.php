<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::Class, 'previous_id', 'id');
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactiontable');
    }

    public function scopeOfLevel($query, $level)
    {
        $query->where('level', $level);
    }

    protected $fillable = [
        'user_id', 'previous_id', 'level', 'post_id', 'content',
    ];
}
