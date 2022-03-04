<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Notification extends Model
{
    use HasFactory;

    protected $table = "notifications";

    protected $fillable = ['users_id_to', 'id_from', 'data', 'action', 'notifiable_id', 'notifiable_type'];

    public function notifiable()
    {
        return $this->morphTo();
    }

}
