<?php

use App\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::create([
            'category_id' => 1,
            'name' => 'Computers',
            'slug' => 'computers'
        ]);

        Section::create([
            'category_id' => 1,
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones'
        ]);

        Section::create([
            'category_id' => 1,
            'name' => 'Accessories',
            'slug' => 'accessories'
        ]);

        Section::create([
            'category_id' => 1,
            'name' => 'TV Sets',
            'slug' => 'tv-sets'
        ]);

        Section::create([
            'category_id' => 1,
            'name' => 'Audio',
            'slug' => 'audio'
        ]);

        Section::create([
            'category_id' => 1,
            'name' => 'GPS Navigation',
            'slug' => 'gps-navigation'
        ]);

        Section::create([
            'category_id' => 1,
            'name' => 'Air Conditioning',
            'slug' => 'air-conditioning'
        ]);

        Section::create([
            'category_id' => 1,
            'name' => 'Photo And Video',
            'slug' => 'photo-and-video'
        ]);

        Section::create([
            'category_id' => 2,
            'name' => 'Clothes',
            'slug' => 'clothes'
        ]);

        Section::create([
            'category_id' => 2,
            'name' => 'Shoes',
            'slug' => 'shoes'
        ]);

        Section::create([
            'category_id' => 2,
            'name' => 'Accessories',
            'slug' => 'accessories'
        ]);

        Section::create([
            'category_id' => 2,
            'name' => 'Watches',
            'slug' => 'watches'
        ]);

        Section::create([
            'category_id' => 3,
            'name' => 'Cats',
            'slug' => 'cats'
        ]);

        Section::create([
            'category_id' => 3,
            'name' => 'Dogs',
            'slug' => 'dogs'
        ]);

        Section::create([
            'category_id' => 3,
            'name' => 'Exotic fish',
            'slug' => 'exotic-fish'
        ]);

        Section::create([
            'category_id' => 3,
            'name' => 'Birds',
            'slug' => 'birds'
        ]);

        Section::create([
            'category_id' => 3,
            'name' => 'Animal Products',
            'slug' => 'animal-products'
        ]);

        Section::create([
            'category_id' => 4,
            'name' => 'Cars And Car Parts',
            'slug' => 'cars-and-car-parts'
        ]);

        Section::create([
            'category_id' => 4,
            'name' => 'Tires And Wheel Rims',
            'slug' => 'tires-and-wheel-rims'
        ]);

        Section::create([
            'category_id' => 4,
            'name' => 'Trailers And Caravans',
            'slug' => 'trailers-and-caravans'
        ]);

        Section::create([
            'category_id' => 4,
            'name' => 'Buses And Trucks',
            'slug' => 'buses-and-trucks'
        ]);

        Section::create([
            'category_id' => 5,
            'name' => 'For Sale',
            'slug' => 'for-sale'
        ]);

        Section::create([
            'category_id' => 5,
            'name' => 'For Rent',
            'slug' => 'for-rent'
        ]);

        Section::create([
            'category_id' => 5,
            'name' => 'Roommates',
            'slug' => 'roommates'
        ]);

        Section::create([
            'category_id' => 6,
            'name' => 'Industrial Equipment',
            'slug' => 'industrial-equipment'
        ]);

        Section::create([
            'category_id' => 6,
            'name' => 'Business Equipment',
            'slug' => 'business-equipment'
        ]);

        Section::create([
            'category_id' => 6,
            'name' => 'Tools',
            'slug' => 'tools'
        ]);

        Section::create([
            'category_id' => 7,
            'name' => 'Courses, Lessons',
            'slug' => 'courses-lessons'
        ]);

        Section::create([
            'category_id' => 7,
            'name' => 'Medical',
            'slug' => 'medical'
        ]);

        Section::create([
            'category_id' => 7,
            'name' => 'Cleaning',
            'slug' => 'cleaning'
        ]);

        Section::create([
            'category_id' => 7,
            'name' => 'Business Services',
            'slug' => 'business-services'
        ]);
    }
}
