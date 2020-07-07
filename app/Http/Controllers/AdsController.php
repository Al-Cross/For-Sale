<?php

namespace App\Http\Controllers;

use App\Ad;
use App\City;
use App\Section;
use App\Category;
use App\AdSearch\AdSearch;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::latest()->get();
        $categories = Category::all();

        if (request()->wantsJson()) {
            $section = Section::where('category_id', '=', request()->id)->get();
            return $section;
        }

        return view('welcome', compact('ads', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show($category, $section, Ad $ad)
    {
        return view('ads.show', compact('ad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Execute the search query.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = request()->input('query');

        $results = AdSearch::apply($request, (new Ad)->newQuery());

        return view('ads.search', compact('results', 'query'));
    }

    /**
     * Search the desired city.
     *
     * @return \Illuminate\Http\Response
     */
    public function findLocation()
    {
        $input = request()->input('location');

        $location = City::search($input)->get();

        return response()->json($location);
    }
}
