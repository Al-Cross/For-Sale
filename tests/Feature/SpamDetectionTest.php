<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamDetectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    function missing_decoy_field_triggers_an_exception()
    {
    	$this->signIn();

    	$this->message = make('App\Message', [
            'subject' => 'Some title',
            'body' => 'Some text body.',
    	]);

    	$this->response = $this->post(route('send'), $this->message->toArray());

    	$this->response->assertStatus(404);
    }
    /**
     * @test
     */
    public function filled_decoy_field_triggers_an_exception()
    {
    	$this->signIn();

    	$message = make('App\Message', [
            'telephone' => 'Not empty'
    	]);

    	$response = $this->post(route('send'), $message->toArray());

    	$response->assertStatus(404);
    }
    /**
     * @test
     */
    public function fast_form_submission_triggers_an_exception()
    {
    	$this->signIn();

    	$message = make('App\Message', [
            'telephone' => 'Not empty',
            'timestamp' => microtime(true)
    	]);

    	$response = $this->post(route('send'), $message->toArray());

    	$response->assertStatus(404);
    }
}
