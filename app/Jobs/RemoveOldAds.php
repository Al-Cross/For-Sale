<?php

namespace App\Jobs;

use App\Ad;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RemoveOldAds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ads = Ad::where('created_at', '<=', Carbon::now()->subMonth())
            ->with('owner:id,ad_limit')
            ->get();

        foreach ($ads as $ad) {
            $ad->owner->ad_limit++;
            $ad->owner->save();
            $ad->delete();
        }
    }
}
