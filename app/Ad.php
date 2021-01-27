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
    protected $with = ['section', 'observed', 'section.category:id,name,slug', 'images', 'city:id,city'];
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['isBeingObserved'];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('observed', function($builder) {
            $builder->with('observed');
        });
    }

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
     * Define the relationship with App\ObservedAd
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function observed()
    {
        return $this->hasMany(ObservedAd::class);
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

    /**
     * Scope a query to exclude featured ads.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExcludeFeatured($query)
    {
        return $query->where('featured', false);
    }

    /**
     * Scope a query to only include featured ads.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to check if the ad belongs to a category.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $categoryId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->whereHas('section.category', function($q) use ($categoryId) {
            $q->where('id', $categoryId);
        });
    }

    /**
     * Check if the current user observes the ad.
     *
     * @return boolean
     */
    public function isBeingObserved()
    {
        return !! $this->observed->where('user_id', auth()->id())->count();
    }

    /**
     * Get the observed value.
     *
     * @return boolean
     */
    public function getIsBeingObservedAttribute()
    {
        return $this->isBeingObserved();
    }
}
