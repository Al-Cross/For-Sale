<?php

namespace Tests;

use App\Ad;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * A helper function for creating a signed-in user
     * @param  App\User $user
     * @return Object
     */
    protected function signIn($user = null)
    {
        $user = $user ?: create('App\User', ['confirmed' => true]);

        $this->actingAs($user);

        return $this;
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
