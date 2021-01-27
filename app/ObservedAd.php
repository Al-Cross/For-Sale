<?php

namespace App;

use App\Providers\LoweredPrice;
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

    /**
     * Define the relationship with App\User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Notify the user about a lower price.
     *
     * @param App\Ad $ad
     * @param int $oldPice
     *
     * @return void
     */
    public function lowerPriceNotification($ad, $oldPice)
    {
        if ($ad->price < $oldPice) {
            event(new LoweredPrice($ad, $this->user));
        }
    }
}
