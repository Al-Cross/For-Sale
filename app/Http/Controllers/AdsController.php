<?php

namespace App\Http\Controllers;

use App\Ad;
use App\City;
use App\Image;
use App\Section;
use App\Category;
use App\AdSearch\AdSearch;
use Illuminate\Support\Str;
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
        $featured = Ad::where('featured', true)->get();
        $categories = Category::all();

        if (request()->wantsJson()) {
            $section = Section::where('category_id', '=', request()->id)->get();
            return $section;
        }

        return view('welcome', compact('ads', 'featured', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('sections')->get();

        return view('ads.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'section_id' => 'required',
            'city' => 'required',
            'title' => ['required', 'string'],
            'description' => ['required', 'min:10'],
            'price' => ['required', 'numeric'],
            'type' => ['required', 'string', 'in:private,business'],
            'condition' => ['required', 'string', 'in:new,used'],
            'delivery' => ['required', 'string', 'in:seller,buyer,personal handover'],
            'image' => 'array',
            'image.*' => ['image', 'mimes:jpeg,jpg,png']
        ]);

        $city_id = City::whereCity($data['city'])->first()->id;

        $ad = Ad::create([
            'section_id' => $data['section_id'],
            'user_id' => auth()->id(),
            'city_id' => $city_id,
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'],
            'price' => $data['price'],
            'type' => $data['type'],
            'condition' => $data['condition'],
            'delivery' => $data['delivery']
        ]);

        if (request()->has('image')) {
            $this->saveImages($ad->id, request()->file('image'));
        }

        return redirect(route('profile'))->with('flash', 'Your ad has been successfully posted!');
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
        $results = AdSearch::apply($request, (new Ad)->newQuery());

        return view('ads.search', compact('results'));
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

    /**
     * Store the images.
     *
     * @param array $images
     */
    public function saveImages($adId, $images)
    {
        $paths = [];
        foreach ($images as $image) {
            $imageName = $image->hashName();
            $paths[] = $image->storeAs('images', $imageName);
        }

        foreach ($paths as $path) {
            Image::create([
                'ad_id' => $adId,
                'path' => $path
            ]);
        }
    }
}
