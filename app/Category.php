<?php

namespace App;

use App\Section;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $guarded = [];

    /**
     * Define the relationship with App\Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Define the relationship with App\Ad
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function ads()
    {
        return $this->hasManyThrough(Ad::class, Section::class);
    }

    /**
     * Check if the category contains the given ad.
     *
     * @param  App\Ad  $ad
     * @return boolean
     */
    public function hasAd($ad)
    {
        return $this->ads->contains($ad);
    }
}
