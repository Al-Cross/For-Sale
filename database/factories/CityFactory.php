<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use Faker\Factory;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

// Use the German cities instead of random locations
$filename = realpath(__DIR__ . '/../seeds/cities.sql');
$filePointer = @fopen($filename, 'r');

if ($filePointer) {
    $cities = explode("\n", fread($filePointer, filesize($filename)));
}
@fclose($filePointer);

$trimmed = array_diff_key($cities, [0 => 'x', 1 => 'x', 2 => 'x', 3 => 'x', 254 => 'x']);
$trimmed = array_values($trimmed);

for ($i=0; $i <= 364; $i++) {
    list($id[], $city[], $latitude[], $longitude[]) = explode(",", $trimmed[$i]);
}
$randomCity = mt_rand(1, 364);

$lat = trim($latitude[$randomCity], " \"");
$long = trim($longitude[$randomCity], " \"");
$location = new Point($lat, $long, 4326);

$factory->define(City::class, function (Faker $faker) use ($city, $latitude, $longitude) {
    $randomCity = $faker->numberBetween(1, 364);
    $city = trim($city[$randomCity], " \"");
    $lat = trim($latitude[$randomCity], " \"");
    $long = trim($longitude[$randomCity], " \"");

    return [
        'city' => $city,
        'latitude' => $lat,
        'longitude' => $long,
        'location' => null,
        'admin' => 'Berlin',
        'iso2' => 'DE',
        'country' => 'Germany'
    ];
});

$factory->state(City::class, 'withLocation', function() use ($location) {
    return ['location' => $location];
});
