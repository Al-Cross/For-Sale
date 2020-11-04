<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeletionEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user_id;

    /**
     * Create a new message instance.
     *
     * @param  $user_id
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.deletion_email');
    }
}
