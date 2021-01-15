<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ObservedAdsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_observe_ads()
    {
    	$this->post('/favourite', ['ad_id' => 1])
    		->assertRedirect('/login');

    }
    /**
     * @test
     */
    function signed_in_users_can_visit_their_favourite_ads_page()
    {
    	$this->signIn();

    	$this->get('/observed')
    		->assertStatus(200);
    }
    /**
     * @test
     */
    public function signed_in_users_may_observe_an_ad()
    {
    	$this->signIn();
    	$ad = create('App\Ad');

    	$this->post('/favourite', ['ad_id' => $ad->id]);

    	$this->assertCount(1, auth()->user()->observed);
    	$this->assertDatabaseHas('observed_ads', ['ad_id' => $ad->id]);
    }
    /**
     * @test
     */
    public function signed_in_users_can_see_their_favourite_ads()
    {
    	$this->signIn();
    	$ad = create('App\Ad');

    	$this->post('/favourite', ['ad_id' => $ad->id]);
    	$this->get('/observed')
    		->assertSee($ad->title);
    }
    /**
     * @test
     */
    public function observed_ads_may_be_unfavourited()
    {
    	$this->signIn();
    	$ad = create('App\Ad');

    	$this->post('/favourite', ['ad_id' => $ad->id]);
    	$this->delete('/unfavourite', ['ad_id' => $ad->id]);

    	$this->get('/observed')
    		->assertDontsee($ad->title);
    }
}
