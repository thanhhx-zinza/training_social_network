<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;

    public function getStrangeUsers($currentUser)
    {
        $relationUsers = $currentUser->users()->get();
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
