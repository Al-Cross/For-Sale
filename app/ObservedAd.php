<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObservedAd extends Model
{
    protected $table = 'observed_ads';
    protected $guarded = [];

    /**
     * Define the relationship with App\Ad
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad()
    {
    	return $this->belongsTo(Ad::class);
    }
}
