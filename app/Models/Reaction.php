<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
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

    public function comment()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfType($query, $type)
    {
        $query->where('type', $type);
    }

    public function scopePostExists($query, $post_id)
    {
        return $query->post_id == $post_id;
    }

    public function scopeUserLiked($query, $user_id)
    {
        $query->where('user_id', $user_id);
    }

    protected $fillable = [
        'user_id', 'post_id', 'type', 'comment_id',
    ];
}
