<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Ad extends Model
{
    use SearchableTrait;

    protected $guarded = [];
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
            'ads.title' => 10,
            'ads.description' => 5
        ]
    ];
    /**
     * The URL to the resource.
     *
     * @return string
     */
    public function path()
    {
        return "/{$this->section->category->slug}/{$this->section->slug}/{$this->slug}";
    }

    /**
     * Define the relationship with App\Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Define the relationship with App\City
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Define the relationship with App\Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define the relationship with App\Image
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get the path to the main image.
     *
     * @return string
     */
    public function mainImage()
    {
        if ($this->images->isEmpty()) {
            return 'images/default-image.jpg';
        }

        return $this->images->where('ad_id', $this->id)->first()->path;
    }
}
