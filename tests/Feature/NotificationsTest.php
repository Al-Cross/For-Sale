<?php

namespace Tests\Feature;

use App\Message;
use Tests\TestCase;
use App\Mail\NewMessage;
use Illuminate\Support\Facades\Mail;
use App\Providers\NewMessageReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        $this->john = create('App\User', ['name' => 'John Doe']);
        $this->jane = create('App\User', ['name' => 'Jane Doe']);
        $this->jane->notificationSettings()->create();
        $this->signIn($this->john);

        $this->message = make(
            'App\Message',
            ['creator_id' => $this->john->id, 'recipient_id' => $this->jane->id]
        );

        $this->post(route('send'), $this->message->toArray());
        $this->persistedMessage = Message::whereSubject($this->message->subject)->first();
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
    /**
     * @test
     */
    public function an_email_is_sent_upon_receiving_new_message()
    {
        Mail::fake();

        event(new NewMessageReceived($this->persistedMessage, $this->jane));

        Mail::assertQueued(NewMessage::class);
    }
    /**
     * @test
     */
    public function no_email_notification_is_fired_if_the_user_has_turned_notifs_off()
    {
        Mail::fake();
        $this->signIn($this->jane);

        $this->patch(
            '/myaccount/settings/notifications',
            ['newMessage' => false]
        );

        event(new NewMessageReceived($this->persistedMessage, $this->jane));

        Mail::assertNotQueued(NewMessage::class);
    }
}
