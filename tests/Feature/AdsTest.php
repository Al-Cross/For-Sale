<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
