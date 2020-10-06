<?php

namespace Tests\Feature;

use App\Message;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->john = create('App\User');
        $this->jane = create('App\User');
        $this->signIn($this->john);
        $this->message = make(
            'App\Message',
            ['creator_id' => $this->john->id, 'recipient_id' => $this->jane->id]
        );

        $this->post(route('send'), $this->message->toArray());
        $this->id = Message::whereSubject($this->message->subject)->first()->id;
    }

    /**
     * @test
     */
    public function notification_is_sent_on_received_message()
    {
        $this->signIn($this->jane);

        $this->assertCount(1, $this->jane->fresh()->notifications);
    }
    /**
     * @test
     */
    public function user_can_mark_their_notifications_as_read()
    {
        $this->signIn($this->jane);
        $this->assertCount(1, $this->jane->unreadNotifications);

        $notificationId = $this->jane->unreadNotifications->first()->id;
        $this->delete(route('destroy-notif', $notificationId));

        $this->assertCount(0, $this->jane->fresh()->unreadNotifications);
    }
    /**
     * @test
     */
    public function users_can_access_their_notifications()
    {
        $this->signIn($this->jane);

        $response = $this->getJson('myaccount/notifications')->json();

        $this->assertCount(1, $response);
    }
}
