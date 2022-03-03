<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Auth;

class NotificationFeedBackAddFriend extends Notification
{
    use Queueable;

    private $feedback;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomDbChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
       // dd($this->feedback);
      if($this->feedback){
        if ($this->feedback->typeNoti == "accept") {
            return [
                'action' => $this->feedback->typeNoti,
                'id_from' => $this->feedback->user_id,
                "data" => Auth::user()->name." just accept addfriend",
                "notifiable_id" => random_int(100000, 999999),
            ];
        } elseif($this->feedback->typeNoti == "reject") {
            return [
                'action' => $this->feedback->typeNoti,
                'id_from' => $this->feedback->user_id,
                "data" => Auth::user()->name." just reject addfriend",
                "notifiable_id" => random_int(100000, 999999),
            ];
        } else {
            return [
                'action' => $this->feedback->typeNoti,
                'id_from' => $this->feedback->friend_id,
                "data" => Auth::user()->name." just send addfriend",
                "notifiable_id" => random_int(100000, 999999),
            ];
        }
      }
    }
}
