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
        return '/' . $this->slug;
    }
}
