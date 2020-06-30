<?php

namespace Tests\Feature;

use App\Section;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function users_can_see_the_ad_sections()
    {
        $section = create('App\Section');

        $response = $this->get('/');

        $response->assertSee("categories-sections");
    }
    /**
     * @test
     */
    public function users_can_see_all_ads_of_a_section()
    {
        $category = create('App\Category');
        $section = create('App\Section', ['category_id' => $category->id]);
        $adInSection = create('App\Ad', ['section_id' => $section->id]);
        $adNotInSection = create('App\Ad', ['title' => 'Some Title']);

        $response = $this->get(route('section', [$category->slug, $section->slug]));

        $response->assertSee($adInSection->title);
        $response->assertDontSee($adNotInSection->title);
    }
}
