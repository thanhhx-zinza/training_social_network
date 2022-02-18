<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    private static $audiences = [
        'public' => 'Public',
        'private' => 'Private',
        'onlyme' => 'Only me',
        'friends' => 'Friends'
    ];

    public static function getAudiences()
    {
        return self::$audiences;
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCurrentUserPosts($id)
    {
        return self::display()
            ->where('user_id', '=', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public static function getAudienceValue($audienceKey)
    {
        foreach (self::$audiences as $key => $value) {
            if ($audienceKey === $key) {
                return $value;
            }
        }
        return 'Public';
    }

    /**
     * Check audience
     */
    public static function checkAudience($audience)
    {
        if (!in_array($audience, array_flip(self::$audiences))) {
            return false;
        }
        return true;
    }

    public function scopeDisplay($query)
    {
        $query->where('display', 1);
    }
}
