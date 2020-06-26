<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function users_can_see_categories()
    {
        $category = create('App\Category');

        $response = $this->get('/');

        $response->assertSee($category->name);
    }
}
