<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationSettings extends Model
{
    protected $casts = ['new_message' => 'boolean'];
}
