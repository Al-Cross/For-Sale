<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $guarded = [];

    /**
     * Delete from App\Message if the model instance is removed by both users.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($archive) {
            if (!Inbox::where('message_id', $archive->message->id)->exists() && !Sent::where('message_id', $archive->message->id)->exists()) {
                $archive->message->delete();
            }
        });
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
     * Define the relationship with App\Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
