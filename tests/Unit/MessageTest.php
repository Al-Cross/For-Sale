<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function messages_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('messages', [
            'id','creator_id', 'parent_message_id', 'subject', 'body'
        ]),
            1
        );
    }
    /**
     * @test
     */
    public function it_belongs_to_a_user()
    {
        $user = create('App\User');
        $message = create('App\Message', ['creator_id' => $user->id]);

        $this->assertEquals(1, $user->messages->count());
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $user->messages
        );
    }
}
