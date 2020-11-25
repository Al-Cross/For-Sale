<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeaturedAdsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    function users_can_promote_their_ads()
    {
    	$this->signIn();
        $ad = create('App\Ad');
        auth()->user()->balance()->update(['amount' => 3000]);

        $this->patch(route('promote', $ad->id))
        	->assertSessionHas('flash', 'This ad is now featured!');

        $this->assertTrue($ad->fresh()->featured);
        $this->assertEquals(2000, auth()->user()->balance->fresh()->amount);
    }
}
