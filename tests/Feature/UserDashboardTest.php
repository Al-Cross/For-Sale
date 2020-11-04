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
        $this->signIn();

        $this->get(route('profile'))
            ->assertStatus(200)
            ->assertSee('My Ads');
    }
    /**
     * @test
     */
    public function guests_cannot_create_ads()
    {
        $ad = make('App\Ad');

        $this->get(route('new_ad'))
            ->assertRedirect(route('login'));

        $this->post(route('create_ad'), $ad->toArray())
            ->assertRedirect(route('login'));
    }
    /**
     * @test
     */
    public function new_users_must_first_confirm_their_email_before_posting_ads()
    {
        $user = factory('App\User')->states('unconfirmed')->create();

        $this->signIn($user);
        $ad = make('App\Ad');

        $this->post(route('create_ad'), $ad->toArray())
            ->assertRedirect(route('profile'))
            ->assertSessionHas('flash', 'You must first confirm your email address.');
    }
    /**
     * @test
     */
    public function an_authenticated_user_can_create_new_ads()
    {
        $this->signIn();
        $city = create('App\City');

        $this->get(route('new_ad'))
            ->assertSee('Post A New Ad')
            ->assertStatus(200);

        $ad = make('App\Ad', [
            'section_id' => create('App\Section')->id,
            'user_id' => auth()->id(),
            'city' => $city->city,
            'title' => 'Some Ad',
            'slug' => 'some-ad',
            'description' => 'Some description',
            'price' => 9.99,
            'type' => 'private',
            'condition' => 'new',
            'delivery' => 'seller',
            'image' => [0 => $file1 = UploadedFile::fake()->image('AdPhoto1.jpg'),
                        1 => $file2 = UploadedFile::fake()->image('AdPhoto2.jpg')]
        ]);

        $response = $this->post(route('create_ad'), $ad->toArray());

        Storage::disk('public')->assertExists('images/' . $file1->hashName());
        $this->get('/')
            ->assertSee($ad->title)
            ->assertSee($ad->price);
    }
    /**
     * @test
     */
    public function an_ad_requires_a_title()
    {
        $this->postAd(['title' => null])
            ->assertStatus(422);
    }
    /**
     * @test
     */
    public function an_authenticated_user_can_visit_their_profile_settings_page()
    {
        $this->signIn();

        $this->get('/myaccount/settings')
            ->assertStatus(200);
    }
    /**
     * @test
     */
    public function users_can_edit_their_name_and_email()
    {
        $this->signIn();

        $this->patch(
            route('profile_update'),
            ['name' => 'John Dean', 'email' => 'johndoe@gmail.com']
        );

        $this->assertDatabaseHas('users', ['name' => 'John Dean']);
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
    public function a_confirmation_email_is_sent_when_deleting_a_profle()
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

    /**
     * Whip up an ad for testing purposes.
     *
     * @param  array  $overrides
     * @return Http Response
     */
    public function postAd($overrides = [])
    {
        $this->signIn();

        $ad = make('App\Ad', $overrides);

        return $this->postJson(route('create_ad'), $ad->toArray());
    }
}
