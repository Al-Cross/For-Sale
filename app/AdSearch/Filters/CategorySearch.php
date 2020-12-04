<?php

namespace App\AdSearch\Filters;

use App\Category;
use App\AdSearch\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CategorySearch implements Filter
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
            $category = Category::where('id', $value)->first();

            $matchedAds = $builder->get();
            $builder = $matchedAds->filter(function ($ad) use ($category) {
                return $category->hasAd($ad);
            });

            return $builder;
        }

        return $builder->paginate(20);
    }
}
