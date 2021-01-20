<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Mail\DeletionEmail;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDashboardTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function users_can_visit_their_dashboard()
    {
        $this->signIn($user = create('App\User'));
        $user->balance()->create(['amount' => '1000']);

        $this->get(route('profile'))
            ->assertStatus(200)
            ->assertSee('My Ads');
    }
    /**
     * @test
     */
    public function an_authenticated_user_can_visit_their_profile_settings_page()
    {
        $this->signIn($user = create('App\User'));
        $user->balance()->create(['amount' => '1000']);

        $this->get('/myaccount/settings')
            ->assertStatus(200);
    }
    /**
     * @test
     */
    public function users_can_edit_their_profile_details()
    {
        $this->signIn();

        $this->patch(
            route('profile_update'), [
                'name' => 'John Dean',
                'email' => 'johndoe@gmail.com',
                'address' => 'My address',
                'phone' => '01239345659',
                'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
            ]
        );

        $this->assertDatabaseHas('users', ['name' => 'John Dean', 'address' => 'My address']);
    }
    /**
     * @test
     */
    public function users_can_change_their_password()
    {
        $john = create('App\User', ['password' => Hash::make('MyPassword')]);
        $this->signIn($john);

        $this->patch(
            '/myaccount/settings/pass',
            [
                'old_pass' => 'MyPassword',
                'password' => 'MyNewPass'
            ]
        );

        $this->assertTrue(Hash::check('MyNewPass', $john->fresh()->password));
    }
    /**
     * @test
     */
    public function users_can_toggle_their_email_notifications_on_and_off()
    {
        $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'MyPassword',
            'password_confirmation' => 'MyPassword'
        ]);

        $this->assertDatabaseHas('notification_settings', ['new_message' => true]);

        $this->patch(
            '/myaccount/settings/notifications',
            ['newMessage' => false]
        );

        $this->assertDatabaseHas('notification_settings', ['new_message' => false]);
        $this->assertFalse(auth()->user()->notificationSettings->new_message);
    }
    /**
     * @test
     */
    public function only_members_can_upload_logos()
    {
        $this->post('/myaccount/settings/1/logos')
            ->assertRedirect('/login');
    }
    /**
     * @test
     */
    public function a_valid_image_must_be_provided()
    {
        $this->signIn();

        $this->post('/myaccount/settings/' . auth()->id() . '/logos', [
            'image' => 'not-an-image'
        ])->assertStatus(302);
    }
    /**
     * @test
     */
    public function a_user_may_add_and_remove_an_image_to_their_profile()
    {
        $this->signIn();

        Storage::fake();

        $this->post('/myaccount/settings/' . auth()->id() . '/logos', [
            'image' => $file = uploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertEquals('logos/' . $file->hashName(), auth()->user()->fresh()->avatar);
        Storage::disk('public')->assertExists('logos/' . $file->hashName());

        $this->delete('/myaccount/settings/' . auth()->id() . '/logos/delete');

        $this->assertEquals('users/default.png', auth()->user()->fresh()->avatar);
        Storage::disk('public')->assertMissing('logos/' . $file->hashName());
    }
    /**
     * @test
     */
    public function a_confirmation_email_is_sent_when_deleting_a_profile()
    {
        Mail::fake();
        $this->signIn();

        $this->post(route('deletion_email'));

        Mail::assertQueued(DeletionEmail::class);
    }
    /**
     * @test
     */
    public function a_user_may_delete_their_profile()
    {
        $this->signIn();
        $ad = create('App\Ad', ['user_id' => auth()->id()]);

        $this->get(route('profile_deletion', auth()->id()));

        $this->assertDatabaseMissing('users', ['id' => auth()->id()]);
        $this->assertDatabaseMissing('ads', ['id' => $ad->id]);
    }
}
