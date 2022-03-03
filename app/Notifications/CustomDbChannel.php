<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Str;
class CustomDbChannel
{

  public function send($notifiable, Notification $notification)
  {
    $data = $notification->toDatabase($notifiable);
    return $notifiable->routeNotificationFor('database')->create([
        'users_id_to' => Auth::id(),
        'id_from'=> $data['id_from'],
        "action" => $data['action'],
        'type' => get_class($notification),
        'data' => $data,
        'read_at' => null,
        "notifiable_id" => $data['notifiable_id'],
    ]);
  }
}
