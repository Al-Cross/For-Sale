<?php

namespace App;

use App\User_Messages;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'type', 'password', 'avatar', 'confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'confirmed' => 'boolean',
        'ad_limit' => 'integer'
    ];

    /**
     * Define the relationship with App\Sent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentMessages()
    {
        return $this->hasMany(Sent::class);
    }

    /**
     * Define the relationship with App\Inbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inbox()
    {
        return $this->hasMany(Inbox::class);
    }

    /**
     * Define the relationship with App\Ad
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    /**
     * Define the relationship with App\Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'creator_id');
    }

    /**
     * Define the relationship with App\Balance
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    /**
     * Define the relationship with App\Archive
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function archivedMessages()
    {
        return $this->hasMany(Archive::class);
    }

    /**
     * Define the relationship with App\NotificationSettings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function notificationSettings()
    {
        return $this->hasOne(NotificationSettings::class);
    }

    /**
     * Update the confirmation status of the user.
     *
     * @return Model
     */
    public function confirm()
    {
        $this->confirmed = true;

        $this->email_verified_at = now();

        $this->confirmation_token = null;

        return $this->save();
    }

    /**
     * Grant the user the desired amount of additional ads.
     *
     * @param string $type  The desired membership type
     * @param int    $price The deductible price of the membership
     *
     * @return Illuminate\Http\Response
     */
    public function upgrade($type, $price)
    {
        if (! ($this->balance->amount < $price)) {
            $this->type = $type;
            $this->save();
            $this->balance->amount = $this->balance->amount - $price;
            $this->balance()->update(['amount' => $this->balance->amount]);
            $this->updateAdLimit($type);

            return true;
        }

        return false;
    }

    /**
     * Store the ad posting limit in the database.
     *
     * @param str $membershipType
     *
     * @return void
     */
    public function updateAdLimit($membershipType = null)
    {
        if ($membershipType) {
            $this->ad_limit = $this->ad_limit + config('for-sale.membership.' . $membershipType . '.ad_limit');
            $this->save();

            return;
        }

        $this->ad_limit = --$this->ad_limit;
        $this->save();

        if (! $membershipType && $this->ad_limit == config('for-sale.membership.basic.ad_limit')) {
            $this->type = 'basic';
            $this->save();
        }
    }
}
