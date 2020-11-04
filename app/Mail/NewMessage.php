<?php

namespace App\Mail;

use App\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $ad;

    /**
     * Create a new message instance.
     *
     * @param  App\Ad $ad
     * @return void
     */
    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new_message')
            ->with(['adTitle' => $this->ad->title]);
    }
}
