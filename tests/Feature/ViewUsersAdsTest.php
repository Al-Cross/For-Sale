<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewUsersAdsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    function view_all_ads_of_a_given_user()
    {
    	$this->signIn();
    	$creator = create('App\User');
    	$ad = create('App\Ad', ['user_id' => $creator->id]);

    	$this->get(route('user_ads', $creator->name))
    		->assertSee($ad->title);
    }
    /**
     * @test
     */
    public function view_description_and_contact_info_of_a_user()
    {
        $this->signIn();
        $viewedUser = create('App\User');

        $this->get(route('user_ads', $viewedUser->name))
            ->assertSee($viewedUser->about)
            ->assertSee($viewedUser->phone);
    }
}
