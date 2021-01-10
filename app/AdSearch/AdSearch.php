<?php

namespace App\AdSearch;

use App\Ad;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class AdSearch
{
    /**
     * Search the ads according to the specified filter(s).
     *
     * @param  Request $filters
     * @param  Builder $query
     * @return Collection
     */
    public static function apply(Request $filters)
    {
        $query = static::applyDecoratorsFromRequest($filters, (new Ad)->newQuery());

        return (new self)->paginate($filters, $query);
    }

    /**
     * Apply the filters.
     *
     * @param  Request $request
     * @param  Builder $query
     * @return Eloquent
     */
    private static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        foreach ($request->all() as $filterName => $value) {
            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }

        return $query->all();
    }

    /**
     * Create the namespace of a filter class.
     *
     * @param  string $filterName
     * @return Object
     */
    private static function createFilterDecorator($filterName)
    {
        return __NAMESPACE__ . '\\Filters\\' .
            str_replace(' ', '', ucwords(
                str_replace('_', '', $filterName)
            ));
    }

    /**
     * Check if the filter class exists.
     *
     * @param  Object  $decorator
     * @return boolean
     */
    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    /**
     * Create the pagination for the search results.
     *
     * @param Request $request The filters from the request
     * @param array  $query The results from the search
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(Request $request, $query)
    {
        $currentPage = $request->page ?: 1;
        $results = array_slice($query, 10 * ($currentPage - 1), 10);

        return new LengthAwarePaginator($results,
            count($query),
            10,
            $request->page ?: 1,
            ['path' => 'search?searchTerm=' . $request->searchTerm
                . '&city=' . $request->city
                . '&categorySearch=' . $request->categorySearch]
        );
    }
}
