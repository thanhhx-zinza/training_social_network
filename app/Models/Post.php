<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function getAudiences()
    {
        return [
            'public' => 'Public',
            'private' => 'Private',
            'onlyme' => 'Only me',
            'friends' => 'Friends'
        ];
    }
}
