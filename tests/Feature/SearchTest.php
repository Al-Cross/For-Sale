<?php

namespace Tests\Feature;

use App\City;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function users_can_search_ads()
    {
        $query = 'interesting';
        $ad = create('App\Ad', ['title' => "Some {$query} ad"]);
        $adNotInquery = create('App\Ad');

        $this->get("/search?query={$query}")
            ->assertSee($ad->title)
            ->assertDontSee($adNotInquery);
    }
    /**
     * @test
     */
    public function users_can_search_ads_according_to_category()
    {
        $category = create('App\Category');
        $section = create('App\Section', ['category_id' => $category->id]);
        $adInCategory = create('App\Ad', ['section_id' => $section->id]);

        $this->get("/search?categorySearch={$category->id}")
            ->assertSee($adInCategory->title);
    }
    /**
     * @test
     */
    public function users_can_search_ads_according_to_location()
    {
        $city = create('App\City');
        $ad = create('App\Ad', ['city_id' => $city->id]);

        $this->get("/search?city={$city->city}")
            ->assertSee($ad->title);
    }
}
