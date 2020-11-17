<?php

namespace App\Http\Composers;

use Illuminate\View\View;

class Error403Composer
{
	 /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
    	//
    }
	/**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
	public function compose(View $view)
	{
		$view->with('balance', auth()->user()->balance->getBalance());
	}
}
