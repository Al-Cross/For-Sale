<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics'
        ]);

        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion'
        ]);

        Category::create([
            'name' => 'Animals',
            'slug' => 'animals'
        ]);

        Category::create([
            'name' => 'Cars',
            'slug' => 'cars'
        ]);

        Category::create([
            'name' => 'Real Estate',
            'slug' => 'real-estate'
        ]);

        Category::create([
            'name' => 'Tools And Equipment',
            'slug' => 'tools-and-equipment'
        ]);

        Category::create([
            'name' => 'Services',
            'slug' => 'services'
        ]);
    }
}
