<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
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
}
