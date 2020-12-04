<?php

use App\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = base_path('database\seeds\cities.sql');

        DB::unprepared(file_get_contents($sql));

        $cities = City::all();

        foreach ($cities as $city) {
            $city->location = new Point($city->longitude, $city->latitude, 4326);
            $city->save();
        }
    }
}
