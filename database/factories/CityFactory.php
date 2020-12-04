<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use Faker\Factory;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

$faker = Factory::create('de_DE');
$latitude = $faker->latitude();
$longitude = $faker->longitude();
$location = new Point($latitude, $longitude, 4326);

$factory->define(City::class, function (Faker $faker) use ($latitude, $longitude) {
    return [
        'city' => $faker->city,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'location' => null,
        'admin' => 'Berlin',
        'iso2' => 'DE',
        'country' => 'Germany'
    ];
});

$factory->state(City::class, 'withLocation', function() use ($location) {
    return ['location' => $location];
});
