<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Archive;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ArchiveController extends Controller
{
    /**
     * Store an archived message in storage.
     *
     * @param  App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function archiveMessage(Message $message)
    {
        $message->archive(auth()->id());

        return back()->with('flash', 'The selected message has been archived.');
    }

    /**
     * Remove the specified archived message from storage.
     *
     * @param  int  $id App\Message Id
     * @return \Illuminate\Http\Response
     */
    public function destroyMessage($id)
    {
        $message = Archive::findOrFail($id);

        $message->delete();

        return back()->with('flash', 'Message successfully removed!');
    }

    /**
     * Store an archived ad in storage.
     *
     * @param App\Ad     $ad
     *
     * @return \Illuminate\Http\Response
     */
    public function archiveAd(Ad $ad)
    {
        $ad->archive();

        return back()->with('flash', 'Ad has been archived.');
    }

    /**
     * Reactivate an expired ad.
     *
     * @param App\Ad     $ad
     *
     * @return \Illuminate\Http\Response
     */
    public function activateAd(Ad $ad)
    {
        if ($ad->archived) {
            $ad->activate();
            return back()->with('flash', 'Ad has been activated!');
        }

    }

    /**
     * Reactivate an exiring ad.
     *
     * @param App\Ad     $ad
     *
     * @return \Illuminate\Http\Response
     */
    public function extend(Ad $ad)
    {
        if ($ad->created_at < Carbon::now()->subDays(27)) {
            if (auth()->user()->balance->amount > config('for-sale.prices.ad_extention')) {
                $ad->activateBeforeExpiry();

                return back()->with('flash', 'Ad has been extended!');
            }

            return back()->with('flash', 'Insufficient funds. Load your balance first.');
        }

        return back()->with('flash', 'This ad is not eligible for extention.');
    }
}
