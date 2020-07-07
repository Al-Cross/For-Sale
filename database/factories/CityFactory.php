<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    return [
        'city' => $faker->city,
        'latitude' => $faker->latitude(),
        'longitude' => $faker->longitude(),
        'admin' => 'Berlin',
        'iso2' => 'DE',
        'country' => $faker->country
    ];
});
