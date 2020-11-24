<?php

namespace Tests\Feature;

use App\Ad;
use Carbon\Carbon;
use Tests\TestCase;
use App\Jobs\RemoveOldAds;
use App\Jobs\ArchiveExpiredAds;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function users_can_browse_promo_ads()
    {
        $ad = create('App\Ad');

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($ad->title);
    }

    /**
     * @test
     */
    public function users_can_see_an_ad()
    {
        $ad = create('App\Ad');

        $response = $this->get($ad->path());

        $response->assertStatus(200);
        $response->assertSee($ad->title);
        $response->assertSee($ad->description);
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

        $ad = $this->postAd([
            'city' => $city->city,
            'image' => [0 => $file1 = UploadedFile::fake()->image('AdPhoto1.jpg'),
                        1 => $file2 = UploadedFile::fake()->image('AdPhoto2.jpg')]
        ]);

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
        $this->signIn();
        $ad = make('App\Ad', [
            'city' => create('App\City')->city,
            'title' => null
        ]);

        $this->postJson(route('create_ad'), $ad->toArray())
            ->assertStatus(422);
    }
    /**
     * @test
     */
    public function a_user_cannot_create_more_than_three_ads()
    {
        $this->signIn($user = create('App\User'));
        create('App\Ad', ['user_id' => $user->id], 3);
        $user->ad_limit = 0;
        $user->save();

        $this->get(route('new_ad'))->assertStatus(403);
    }
    /**
     * @test
     */
    public function unauthorized_users_may_not_update_ads()
    {
        $this->signIn();
        $ad = create('App\Ad', ['user_id' => create('App\User')->id]);

        $this->get(route('edit_ad', $ad->slug))
            ->assertStatus(403);

        $this->patch(route('update_ad', $ad->id), [])
            ->assertStatus(403);
    }
    /**
     * @test
     */
    public function authorized_users_can_visit_the_ad_edit_page()
    {
        $this->signIn();
        $ad = create('App\Ad', ['user_id' => auth()->id()]);

        $this->get(route('edit_ad', $ad->slug))
            ->assertStatus(200)
            ->assertSee($ad->title);
    }
    /**
     * @test
     */
    public function users_can_edit_their_ads()
    {
        $this->signIn();
        $ad = create('App\Ad', ['user_id' => auth()->id()]);
        $city = create('App\City');

        $this->patch(route('update_ad', $ad->id), [
            'title' => 'Changed',
            'description' => 'Changed description.',
            'city' => $city->city,
            'price' => 2900,
            'type' => 'business',
            'condition' => 'used',
            'delivery' => 'buyer'
        ]);

        tap($ad->fresh(), function($ad) use ($city) {
            $this->assertEquals('Changed', $ad->title);
            $this->assertEquals('Changed description.', $ad->description);
            $this->assertEquals($city->id, $ad->city_id);
            $this->assertEquals(2900, $ad->price);
        });
    }
    /**
     * @test
     */
    public function users_may_archive_their_ads()
    {
        $this->signIn();
        $ad = $this->postAd(['city' => create('App\City')->city]);

        $this->assertEquals(2, auth()->user()->fresh()->ad_limit);

        $this->patch(route('archive-ad', $ad->id))
            ->assertSessionHas('flash', 'Ad has been archived.');

        $this->assertTrue($ad->fresh()->archived);
        $this->assertEquals(3, auth()->user()->fresh()->ad_limit);
    }
    /**
     * @test
     */
    public function users_may_delete_ad_images()
    {
        $this->signIn();
        $ad = $this->postAd([
            'city' => create('App\City')->city,
            'image' => [0 => $file1 = UploadedFile::fake()->image('AdPhoto1.jpg'),
                        1 => $file2 = UploadedFile::fake()->image('AdPhoto2.jpg')]
        ]);

        Storage::disk('public')->assertExists('images/' . $file2->hashName());

        $this->delete(route('delete_ad_image', $ad->images[1]->id));

        Storage::disk('public')->assertMissing('images/' . $file2->hashName());
        $this->assertDatabaseMissing('images', ['id' => $ad->images[1]->id]);
    }
    /**
     * @test
     */
    public function ads_expire_after_30_days_and_get_archived()
    {
        $ad = create('App\Ad', ['created_at' => Carbon::now()->subMonth()]);

        $this->assertFalse($ad->archived);

        $job = new ArchiveExpiredAds();
        $job->handle();

        $this->assertTrue($ad->fresh()->archived);
    }
    /**
     * @test
     */
    public function users_may_reactivate_ads_3_days_before_expiring()
    {
        $this->signIn($john = create('App\User'));
        $extendableAd = create('App\Ad', [
            'user_id' => $john->id,
            'created_at' => Carbon::now()->subDays(27)
        ]);
        $nonExtendableAd = create('App\Ad');
        $newExpirationDate = $extendableAd->created_at->addMonth();
        $balance = $john->balance()->update(['amount' => 3000]);

        $this->patch(route('extend-ad', $extendableAd->id))
            ->assertSessionHas('flash', 'Ad has been extended!');

        $this->assertEquals($newExpirationDate, $extendableAd->fresh()->created_at);
        $this->assertFalse($extendableAd->fresh()->archived);
        $this->assertEquals(2801, $john->balance->fresh()->amount);

        $this->patch(route('extend-ad', $nonExtendableAd->id))
            ->assertSessionHas('flash', 'This ad is not eligible for extention.');

        $this->assertEquals(
            Carbon::now()->toDateString(),
            $nonExtendableAd->fresh()->created_at->toDateString()
        );
    }
    /**
     * @test
     */
    public function users_can_reactivate_expired_ads()
    {
        $this->signIn();
        $ad = create('App\Ad', ['archived' => true]);

        $this->patch(route('activate-ad', $ad->id))
            ->assertSessionHas('flash', 'Ad has been activated!');

        $this->assertFalse($ad->fresh()->archived);
    }
    /**
     * @test
     */
    public function an_ad_older_than_6_months_gets_deleted()
    {
        $ad = create('App\Ad', ['created_at' => Carbon::now()->subMonths(6)]);

        $job = new RemoveOldAds();
        $job->handle();

        $this->assertDatabaseMissing('ads', ['id' => $ad->id]);
    }
    /**
     * @test
     */
    public function unauthorized_users_may_not_delete_ads()
    {
        $this->signIn();
        $ad = create('App\Ad', ['user_id' => create('App\User')->id]);

        $this->delete(route('delete_ad', $ad->id))
            ->assertStatus(403);
    }
    /**
     * @test
     */
    public function authorized_users_may_delete_their_ads()
    {
        $this->signIn();
        $ad = $this->postAd([
            'city' => create('App\City')->city,
            'image' => [0 => $file1 = UploadedFile::fake()->image('AdPhoto1.jpg'),
                        1 => $file2 = UploadedFile::fake()->image('AdPhoto2.jpg')]
        ]);
        $image = $ad->images[1];

        $this->delete(route('delete_ad', $ad->id));

        $this->assertDatabaseMissing('ads', ['title' => $ad->title]);
        $this->assertDatabaseMissing('images', ['id' => $image->id]);
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

        $this->postJson(route('create_ad'), $ad->toArray());

        return Ad::whereTitle($ad->title)->first();
    }
}
