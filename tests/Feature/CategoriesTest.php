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
    /**
     * @test
     */
    public function users_may_see_all_products_from_a_category()
    {
        $category = create('App\Category');
        $section = create('App\Section', ['category_id' => $category->id]);
        $adInCategory = create('App\Ad', ['section_id' => $section->id]);
        $adNotInCategory = create('App\Ad', ['title' => 'New Title']);

        $this->get('/' . $category->slug)
            ->assertSee($adInCategory->title)
            ->assertDontSee($adNotInCategory->title);
    }
}
