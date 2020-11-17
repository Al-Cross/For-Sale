<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
	protected $guarded = [];

	/**
     * Retrieve and format the amount on the user's account.
     *
     * @return int
     */
    public function getBalance()
    {
        return number_format($this->amount / 100, 2);
    }
}
