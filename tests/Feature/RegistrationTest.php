<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\ConfirmYourEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        event(new Registered(create('App\User')));

        Mail::assertQueued(ConfirmYourEmail::class);
    }
    /**
     * @test
     */
    public function user_can_fully_confirm_their_email()
    {
        Mail::fake();

        $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $user = User::whereName('John Doe')->first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $this->get('/register/confirm?token=' . $user->confirmation_token)
            ->assertRedirect('/myaccount');

        tap($user->fresh(), function ($user) {
            $this->assertTrue($user->confirmed);
            $this->assertNull($user->confirmation_token);
        });
    }
    /**
     * @test
     */
    public function confirming_an_invalid_token()
    {
        $this->signIn();

        $this->get('/register/confirm?token=invalid')
            ->assertRedirect('/myaccount')
            ->assertSessionHas('flash', 'Unknown token');
    }
    /**
     * @test
     */
    public function unauthenticated_users_cannot_send_messages()
    {
        $message = make('App\Message');

        $this->get(route('messages'))
            ->assertRedirect(route('login'));

        $this->post(route('send'), $message->toArray())
            ->assertRedirect(route('login'));
    }
}
