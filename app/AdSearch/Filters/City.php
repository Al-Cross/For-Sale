<?php

namespace App\AdSearch\Filters;

use App\AdSearch\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class City implements Filter
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
            $location = \App\City::where('city', $value)->first()->id;

            // I'm using whereRaw because I added the search term to the query in the previous filter
            // and now the term gets added as a binding in the WHERE clause of this query.
            // As a side effect of using whereRaw I must add the $location as a binding
            // so it can be used in the next filter.
            return $builder->whereRaw("city_id = " . $location)
                ->addBinding($location);
        }

        return $builder;
    }
}
