<?php

namespace Tests\Feature;

use App\Ad;
use Tests\TestCase;
use App\Jobs\RemoveOldAds;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAdsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function users_cannot_buy_ads_with_unsufficient_funds()
    {
        $this->signIn($user = create('App\User'));
        create('App\Ad', ['user_id' => $user->id], 3);

        $this->get(route('advanced_upgrade'))
            ->assertSessionHas('flash', 'Unsufficient funds. First load your account.');

        $this->assertEquals('basic', $user->type);
    }
    /**
     * @test
     */
    function authenticated_users_can_buy_3_additional_ads()
    {
    	$this->signIn($user = create('App\User'));
    	create('App\Ad', ['user_id' => $user->id], 3);
    	$user->balance()->update(['amount' => '3000']);

    	$this->get(route('advanced_upgrade'))
    		->assertSessionHas('flash', 'You can now post three additional ads!');

    	$this->get(route('new_ad'))
    		->assertStatus(200);
    	$this->assertEquals(0, $user->balance->amount);
    }
    /**
     * @test
     */
    public function user_type_changes_when_buying_additional_ads()
    {
        $this->signIn($user = create('App\User'));
        $user->balance()->update(['amount' => '3000']);

        $this->get(route('advanced_upgrade'));

    	$this->assertEquals('advanced', $user->type);
    }
    /**
     * @test
     */
    public function authenticated_users_can_buy_10_additional_ads()
    {
        $this->signIn($user = create('App\User'));
        create('App\Ad', ['user_id' => $user->id], 3);
        $user->balance()->update(['amount' => '8000']);

        $this->get(route('premium_upgrade'))
            ->assertSessionHas('flash', 'You can now post ten additional ads!');

        $this->get(route('new_ad'))
            ->assertStatus(200);
        $this->assertEquals(0, $user->balance->amount);
    }
    /**
     * @test
     */
    public function the_ad_posting_limit_decreases_when_an_ad_is_published()
    {
        $this->signIn($user = create('App\User'));
        $city = create('App\City');

        $ad = make('App\Ad', ['user_id' => $user->id, 'city' => $city->city]);

        $this->post(route('create_ad'), $ad->toArray());

        $this->assertEquals(2, $user->fresh()->ad_limit);
    }
    /**
     * @test
     */
    public function buying_two_ad_packages_combines_their_ads()
    {
        $this->signIn($user = create('App\User'));
        $user->balance()->update(['amount' => '11000']);

        $this->get(route('advanced_upgrade'));
        $this->get(route('premium_upgrade'));

        $this->assertEquals(17, $user->ad_limit);
        $this->assertEquals(0, $user->balance->getBalance());
    }
    /**
     * @test
     */
    public function expired_ads_increase_the_ad_limit_on_basic()
    {
        $this->signIn($user = create('App\User'));
        $city = create('App\City');

        $ad = make('App\Ad', ['user_id' => $user->id, 'city' => $city->city]);

        $this->post(route('create_ad'), $ad->toArray());
        $postedAd = Ad::whereTitle($ad->title)->first();

        $postedAd->update(['created_at' => Carbon::now()->subMonths(6)]);

        $job = new RemoveOldAds();
        $job->handle();

        $this->assertEquals(3, auth()->user()->fresh()->ad_limit);
    }
}
