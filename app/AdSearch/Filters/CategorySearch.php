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

            (new self)->removeBindings($builder);

            $builder->inCategory($category->id);

            return $builder;
        }

        return $builder;
    }

    /**
     * Remove the bindings added in previous filters.
     * If Distance filter has been applied, the dummy boolean binding has to be removed.
     * If SearchTerm and City filters have been used,
     * the function checks for the existence of their bindings and removes them.
     *
     * @param Builder $builder $builder
     *
     * @return void
     */
    private function removeBindings($builder)
    {
        $bindings = $builder->getBindings();
        if (gettype(end($bindings)) != 'boolean') {
            if (gettype(end($bindings)) === 'integer') {
                array_pop($bindings);
            }
            if (gettype(end($bindings)) === 'string') {
                array_pop($bindings);
            }
            $builder->setBindings($bindings);
        } else {
            array_pop($bindings);
            $builder->setBindings($bindings);
        }
    }
}
