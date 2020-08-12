<?php

namespace Tests;

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
}
