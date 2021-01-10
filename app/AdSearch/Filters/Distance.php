<?php

namespace App\AdSearch\Filters;

use App\Ad;
use App\City;
use App\AdSearch\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class Distance implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     *
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        if ($value != null) {
            $attributes = (new self)->getAttributes($builder, $value);

            $cities = City::whereRaw(
                "ST_Distance(cities.location, ST_SRID(POINT(?, ?), 4326)) < ?",
                [
                    $attributes['location']->getLng(),
                    $attributes['location']->getLat(),
                    $attributes['distance']
                ]
            )
                ->has('ads')
                ->pluck('id');

            $builder = $attributes['searchInput']
                ? Ad::whereIn('city_id', $cities)
                    ->search($attributes['searchInput'], null, null, true)
                : Ad::whereIn('city_id', $cities);

            return $builder;
        }

        return $builder;
    }

    private function getAttributes($query, $distance)
    {
        $distance = $distance * 1000;
        $bindings = $query->getBindings();
        $city_id = end($bindings);
        $searchTerm = prev($bindings);
        $city = \App\City::where('id', $city_id)->first();
        $point = $city->location;

        return collect([
            'distance' => $distance,
            'searchInput' => $searchTerm,
            'location' => $point
        ]);
    }
}
