<?php

namespace App\Providers;

use App\Ad;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoweredPrice
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ad;
    public $userToBeNotified;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Ad $ad, User $user)
    {
        $this->ad = $ad;
        $this->userToBeNotified = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
