<?php

namespace App\Http\Controllers;

use App\ObservedAd;
use Illuminate\Http\Request;

class ObservedAdsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favourite = auth()->user()->observed->load('ad');

        if (request()->wantsJson()) {
            return $favourite;
        }

    	return view('users.favourite_ads');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function store(Request $request)
    {
    	ObservedAd::firstOrCreate([
    		'user_id' => auth()->id(),
    		'ad_id' => $request->ad_id
    	]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function destroy(Request $request)
    {
        $record = ObservedAd::where('ad_id', $request->ad_id)->firstOrFail();
        $record->delete();
    }
}
