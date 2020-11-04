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
        'name', 'email', 'password', 'avatar', 'confirmation_token'
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
        'confirmed' => 'boolean'
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
}
