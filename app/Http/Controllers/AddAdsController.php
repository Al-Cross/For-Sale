<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Handle the ad packages and upgrading the status of the user.
 */
class AddAdsController extends Controller
{
    /**
     * Display the resource for membership upgrade.
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $balance = auth()->user()->balance->getBalance();

        return view('users.upgrade', compact('balance'));
    }

    /**
     * Upgrade the user to advanced membership.
     *
     * @return Illuminate\Http\Response
     */
    public function advanced()
    {
    	$user = auth()->user();

    	$result = $user->upgrade('advanced', config('for-sale.membership.advanced.price'));

    	if (! $result) {
    		return back()
	            ->with('flash', 'Unsufficient funds. First load your account.');
    	}

    	return redirect(route('profile'))
    		->with('flash', 'You can now post three additional ads!');
    }

    /**
     * Upgrade the user to premium membership.
     *
     * @return Illuminate\Http\Response
     */
    public function premium()
    {
        $user = auth()->user();

        $result = $user->upgrade('premium', config('for-sale.membership.premium.price'));

        if (! $result) {
            return back()
                ->with('flash', 'Unsufficient funds. First load your account.');
        }

        return redirect(route('profile'))
            ->with('flash', 'You can now post ten additional ads!');
    }
}
