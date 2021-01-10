<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Http\Request;

class FeaturedAdsController extends Controller
{
	/**
	 * Update the specified resource in storage.
	 *
	 * @param App\Ad     $ad
	 *
	 * @return Illuminate\Http\Response
	 */
    public function index(Ad $ad)
    {
    	if (auth()->user()->balance->amount >= config('for-sale.prices.featured')) {
    		$ad->feature();

            return back()->with('flash', 'This ad is now featured!');
    	}

        return back()->with('flash', 'Insufficient funds. Load your balance first.');
    }
}
