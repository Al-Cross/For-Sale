<?php

namespace App\AdSearch\Filters;

use App\AdSearch\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class City implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param  Builder $builder
     * @param  mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        if ($value != null) {
            $location = \App\City::where('city', $value)->first()->id;

            return $builder->where('city_id', $location);
        }

        return $builder;
    }
}
