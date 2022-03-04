<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Models\Notification;


class Relation extends Pivot
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "relations";
    protected $fillable = [
        'friend_id', 'type', "id"
    ];

    public function notification(){
        return $this->morphOne(Notification::class, "notifiable");
    }
}
