<?php

namespace App;

use App\UserMessages;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\NewMessageNotification;

class Message extends Model
{
    /**
     * Prevents mass-assignment exception.
     * @var array
     */
    protected $guarded = [];

    /**
     * Define the relationship with App\User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Define the relationship with App\User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

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
     * Define the relationship with App\Inbox
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inbox()
    {
        return $this->hasMany(Inbox::class);
    }

    /**
     * Define the relationship with App\Sent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sent()
    {
        return $this->hasMany(Sent::class);
    }

    /**
     * Define the relationship with App\Archive
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function archived()
    {
        return $this->hasMany(Archive::class);
    }

    /**
     * Archive the selected message and remove it from inbox and sent respectively
     */
    public function archive($userId)
    {
        $this->archived()->create(['user_id' => $userId]);

        if ($this->inbox()->where('user_id', auth()->id())->exists()) {
            $this->inbox()->delete();
        }

        if ($this->sent()->where('user_id', auth()->id())->exists()) {
            $this->sent()->delete();
        }
    }

    /**
     * Distribute the message to the respective folders of the correspondents.
     *
     * @param int $sender
     * @param int $recipient
     */
    public function distribute($sender, $recipient)
    {
        $this->sent()->create(['user_id' => $sender]);
        $this->inbox()->create(['user_id' => $recipient]);

        $userToBeNotified = $this->recipient()->findOrFail($recipient);
        $userToBeNotified->notify(new NewMessageNotification($this));
    }
}
