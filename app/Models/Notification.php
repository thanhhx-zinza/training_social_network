<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = "notices";
    protected $fillable = ["id", 'users_id_to', 'user_id_from', 'data', 'action', 'notifiable_id', 'notifiable_type', 'read_at'];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function scopeGetNotices($query, $idNotifiable)
    {
        return $query->where("notifiable_id", $idNotifiable)->first();
    }
}
