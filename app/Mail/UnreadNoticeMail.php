<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnreadNoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->markdown('emails.unread-notices-email')
                ->subject('Unread Notices')
                ->with(["data" => $this->data]);
    }
}
