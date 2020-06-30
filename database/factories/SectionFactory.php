<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Section;
use App\Category;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Section::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
        'name' => $name,
        'slug' => Str::slug($name)
    ];
});
