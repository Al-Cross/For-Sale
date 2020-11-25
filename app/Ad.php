<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Ad extends Model
{
    use SearchableTrait;

    protected $guarded = [];
    protected $casts = [
        'archived' => 'boolean',
        'featured' => 'boolean'
    ];
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
     * Define the relationship with App\User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define the relationship with App\Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
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

    /**
     * Mark the ad as archived.
     *
     * @return void
     */
    public function archive()
    {
        $this->update(['archived' => true]);
        $this->owner->ad_limit = ++$this->owner->ad_limit;
        $this->owner->save();
    }

    /**
     * Reactivate the ad.
     *
     * @return void
     */
    public function activate()
    {
        $this->update([
            'archived' => false,
            'created_at' => Carbon::now()
        ]);
        $this->owner->updateAdLimit();
    }

    /**
     * Extend the expiration period of the ad.
     *
     * @return void
     */
    public function activateBeforeExpiry()
    {
        $this->update([
            'archived' => false,
            'created_at' => $this->created_at->addMonth()
        ]);

        $this->owner->balance()->update([
            'amount' => $this->owner->balance->amount - config('for-sale.prices.ad_extention')
        ]);

        $this->owner->updateAdLimit();
    }

    /**
     * Promote the ad.
     *
     * @return void
     */
    public function feature()
    {
        $this->owner->balance()->update([
            'amount' => auth()->user()->balance->amount - config('for-sale.prices.featured')
        ]);

        $this->featured = true;
        $this->save();
    }
}
