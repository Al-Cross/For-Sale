<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddAdsController extends Controller
{
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
                ->with('flash', 'Unsufficient funds. First load your account.', 'danger');
        }

        return redirect(route('profile'))
            ->with('flash', 'You can now post ten additional ads!');
    }
}
