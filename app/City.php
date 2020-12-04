<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class City extends Model
{
    use SearchableTrait, SpatialTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'cities.city' => 10,
            'cities.admin' => 5
        ]
    ];
    /**
     * Contains the names of the MySQL spatial data fields.
     *
     * @var array
     */
    protected $spatialFields = ['location'];

    /**
     * Define the relationship with App\Ad
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
