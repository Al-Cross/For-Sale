<?php

namespace App\Providers;

use App\Mail\LoweredPriceEmail;
use App\Providers\LoweredPrice;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\LowerPriceNotification;

class SendLoweredPriceEmail implements ShouldQueue
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
     * @param  LoweredPrice  $event
     * @return void
     */
    public function handle(LoweredPrice $event)
    {
        $event->userToBeNotified->notify(new LowerPriceNotification($event->ad));

        if ($event->userToBeNotified->notificationSettings->lowered_price) {
            Mail::to($event->userToBeNotified)
                ->send(new LoweredPriceEmail($event->ad));
        }
    }
}
