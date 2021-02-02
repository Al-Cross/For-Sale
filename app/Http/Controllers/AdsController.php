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
        $ads = Ad::excludeFeatured()->latest()->paginate(20);
        $featured = Ad::featured()->get();

        if (request()->wantsJson()) {
            $section = Section::where('category_id', '=', request()->id)->get();
            return $section;
        }

        return view('welcome', compact('ads', 'featured'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Ad::class);

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
            'city' => ['required', 'exists:cities'],
            'title' => ['required', 'string'],
            'description' => ['required', 'min:10'],
            'price' => ['required', 'numeric'],
            'type' => ['required', 'string', 'in:private,business'],
            'condition' => ['required', 'string', 'in:new,used'],
            'delivery' => ['required', 'string', 'in:seller,buyer,personal handover'],
            'image' => 'array',
            'image.*' => ['image', 'mimes:jpeg,jpg,png']
        ],
            [
                'city.exists' => 'We do not operate in the selected city.'
            ]
        );

        $city_id = City::whereCity($data['city'])->firstOrFail()->id;


        $ad = Ad::create([
            'section_id' => $data['section_id'],
            'user_id' => auth()->id(),
            'city_id' => $city_id,
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'type' => $data['type'],
            'condition' => $data['condition'],
            'delivery' => $data['delivery']
        ]);

        $ad->createSlug($data['title']);

        auth()->user()->updateAdLimit();

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
        $ad->increment('views');

        $otherAds = $ad->owner->ads()->where('id', '!=', $ad->id)->limit(4)->get();

        return view('ads.show', compact('ad', 'otherAds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        $this->authorize('update', $ad);

        return view('ads.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        $this->authorize('update', $ad);
        $oldPrice = (int) $ad->price;

        $data = $request->validate(
            [
                'city' => ['required', 'exists:cities'],
                'title' => ['required', 'string'],
                'description' => ['required', 'min:10'],
                'price' => ['required', 'numeric'],
                'type' => ['required', 'string', 'in:private,business'],
                'condition' => ['required', 'string', 'in:new,used'],
                'delivery' => ['required', 'string', 'in:seller,buyer,personal handover'],
                'image' => 'array',
                'image.*' => ['image', 'mimes:jpeg,jpg,png']
            ],
            [
                'city.exists' => 'We do not operate in the selected city.'
            ]
        );

        $city_id = City::whereCity($data['city'])->firstOrFail()->id;

        $ad->update([
            'city_id' => $city_id,
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'],
            'price' => $data['price'],
            'type' => $data['type'],
            'condition' => $data['condition'],
            'delivery' => $data['delivery']
        ]);

        $ad->observed->map(function($observed) use ($ad, $oldPrice) {
            $observed->lowerPriceNotification($ad, $oldPrice);
        });

        if (request()->has('image')) {
            $this->saveImages($ad->id, request()->file('image'));
        }

        return redirect(
            route('show_ad', [$ad->section->category->slug, $ad->section->slug, $ad->slug]))
                ->with('flash', 'Your ad has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        $this->authorize('delete', $ad);

        $ad->delete();

        return back()->with('flash', 'Ad successfully removed!');
    }

    /**
     * Execute the search query.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $request->validate(['city' => ['exists:cities', 'nullable']],
            [
                'city.exists' => 'City not found.'
            ]
        );

        $results = AdSearch::apply($request, (new Ad)->newQuery());
        $results = collect($results);
        $private = $results->privateAds();
        $business = $results->businessAds();
        $count = $results->count();

        return view('ads.search', compact('private', 'business', 'count'));
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
