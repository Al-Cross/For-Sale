<?php

namespace Tests\Feature;

use App\Message;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessagesTest extends TestCase
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
    public function an_authenticated_user_can_send_a_message_to_another_user()
    {
        $this->get(route('messages'))
            ->assertSee($this->message->subject);
        $this->assertCount(1, $this->john->sentMessages);
        $this->assertCount(1, $this->jane->inbox);
    }
    /**
     * @test
     */
    public function an_authenticated_user_can_send_a_reply_to_another_user()
    {
        $this->signIn($this->jane);
        $reply = make(
            'App\Message',
            [
                'creator_id' => $this->jane->id,
                'parent_message_id' => $this->message->id,
                'recipient_id' => $this->john->id
            ]
        );

        $this->post(route('send'), $reply->toArray())
            ->assertSessionHas('flash', 'Message successfully sent!');

        $this->assertDatabaseHas('messages', [
            'subject' => $reply->subject, 'parent_message_id' => $this->message->id
        ]);
        $this->assertDatabaseHas('sents', [
            'user_id' => $this->jane->id
        ]);
        $this->assertCount(1, $this->john->inbox);
    }
    /**
     * @test
     */
    public function an_authenticated_user_can_see_received_messages()
    {
        $this->get(route('messages'))
            ->assertSee($this->message->subject)
            ->assertSee($this->message->body);
    }
    /**
     * @test
     */
    public function an_authenticated_user_can_archive_a_message()
    {
        $john = create('App\User');
        $this->signIn($john);
        $message = create('App\Message', ['creator_id' => auth()->id()]);

        $this->post(route('archive', $message->id));

        $this->get(route('messages'))
            ->assertSee($message->subject);

        $this->assertCount(1, $john->archivedMessages);
    }
    /**
     * @test
     */
    public function an_authenticated_user_can_delete_from_their_inbox()
    {
        $this->assertCount(1, $this->jane->inbox);

        $this->delete(route('delete-from-inbox', $this->id))
            ->assertSessionHas('flash', 'Message successfully removed!');

        $this->assertCount(0, $this->jane->fresh()->inbox);
    }
    /**
     * @test
     */
    public function an_authenticated_user_can_delete_from_their_sent_file()
    {
        $this->assertCount(1, $this->john->sentMessages);

        $this->delete(route('delete-from-sent', $this->id))
            ->assertSessionHas('flash', 'Message successfully removed!');

        $this->assertCount(0, $this->john->fresh()->sentMessages);
    }
    /**
     * @test
     */
    public function an_authenticated_user_can_delete_an_archived_message()
    {
        $this->post(route('archive', $this->id));

        $this->assertCount(1, $this->john->archivedMessages);

        $this->delete(route('delete-from-archived', $this->id))
            ->assertSessionHas('flash', 'Message successfully removed!');

        $this->assertCount(0, $this->john->fresh()->archivedMessages);
    }
    /**
     * @test
     */
    public function archiving_a_message_removes_it_from_inbox_or_sent()
    {
        // John archives the message
        $this->post(route('archive', $this->id));

        $this->assertCount(1, $this->jane->fresh()->inbox);
        $this->assertCount(0, $this->john->fresh()->sentMessages);
    }
    /**
     * @test
     */
    public function a_message_is_deleted_when_it_is_absent_from_inbox_sent_and_archive()
    {
        $this->delete(route('delete-from-inbox', $this->id));

        $this->assertDatabaseHas('messages', [
            'subject' => $this->message->subject
        ]);

        $this->post(route('archive', $this->id));

        $this->delete(route('delete-from-sent', $this->id));

        $this->assertDatabaseHas('messages', [
            'subject' => $this->message->subject
        ]);

        $this->delete(route('delete-from-archived', $this->id));

        $this->assertDatabaseMissing('messages', [
            'subject' => $this->message->subject
        ]);
    }
}
