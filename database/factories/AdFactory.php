<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ad;
use App\Section;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Ad::class, function (Faker $faker) {
    $title = $faker->word;

    return [
        'section_id' => function () {
            return factory(Section::class)->create()->id;
        },
        'title' => $title,
        'slug' => Str::slug($title),
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        'price' => 29300.00,
        'type' => 'private',
        'condition' => 'used',
        'views' => 0,
        'featured' => 1
    ];
});
