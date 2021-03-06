<?php

namespace App\AdSearch\Filters;

use App\AdSearch\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchTerm implements Filter
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
        return isset($value)
            ? $builder->search($value)->addBinding($value)
            : $builder->search($value);
    }
}
