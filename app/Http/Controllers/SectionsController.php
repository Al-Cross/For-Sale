<?php

namespace App\Http\Controllers;

use App\Section;
use App\Category;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of all the ads in a category.
     * The collection uses macros to filter the results.
     * Take a look at AppServiceProvider for more info.
     *
     * @param App\Category  $category
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $adsInCategory = $category->ads()->latest()->get();
        $private = $adsInCategory->privateAds();
        $business = $adsInCategory->businessAds();
        $count = $adsInCategory->count();
        $category->load('sections');

        return view('category', compact(
            'category', 'private', 'business', 'count'
        ));
    }

    /**
     * Display a listing of all the ads in a section.
     * The collection uses macros to filter the results.
     * Take a look at AppServiceProvider for more info.
     *
     * @param App\Category  $category
     * @param App\Section $section
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Section $section)
    {
        $section->load('category');
        $adsInSection = $section->ads()->latest()->get();
        $private = $adsInSection->privateAds();
        $business = $adsInSection->businessAds();
        $count = $adsInSection->count();

        return view('section', compact(
            'private', 'business', 'section', 'count'
        ));
    }
}
