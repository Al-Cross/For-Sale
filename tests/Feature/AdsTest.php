<?php

namespace Tests\Feature;

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
    public function archived_ads_are_not_displayed_anywhere()
    {
        $this->signIn();
        $ad = $this->postAd(['city' => create('App\City')->city]);

        $this->patch(route('archive-ad', $ad->id));

        $this->get('/')->assertDontSee($ad->title);
        $this->get(route('user_ads', auth()->user()->name))
            ->assertDontSee($ad->title);
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
    public function users_cannot_reactivate_archived_ads_if_limit_is_reached()
    {
        $this->signIn($john = create('App\User', ['name' => 'John Doe']));
        $ad = create('App\Ad', ['archived' => true, 'user_id' => $john->id]);
        $john->ad_limit = 0;
        $john->save();

        $this->patch(route('activate-ad', $ad->id))
            ->assertSessionHas('flash', 'Posting limit has been reached! Free up or buy additional slots.');

        $this->assertTrue($ad->fresh()->archived);
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
     * @test
     */
    public function a_new_visit_is_recorded_each_time_an_ad_is_visited()
    {
        $ad = create('App\Ad');

        $this->assertSame(0, $ad->views);

        $this->get(route('show_ad', [
            $ad->section->category->slug, $ad->section->slug, $ad->slug
        ]));

        $this->assertEquals(1, $ad->fresh()->views);
    }
}
