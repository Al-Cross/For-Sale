<?php

namespace App\Providers;

use App\Mail\NewMessage;
use Illuminate\Support\Facades\Mail;
use App\Providers\NewMessageReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\NewMessageNotification;

class SendNewMessageNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewMessageReceived  $event
     * @return void
     */
    public function handle(NewMessageReceived $event)
    {
        $event->userToBeNotified
            ->notify(new NewMessageNotification($event->message));

        if ($event->userToBeNotified->notificationSettings->new_message) {
            Mail::to($event->userToBeNotified)
                ->send(new NewMessage($event->message->ad));
        }
    }
}
