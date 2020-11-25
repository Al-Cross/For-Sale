<?php

namespace App\Http\Controllers;

use App\Section;
use App\Category;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param App\Category  $category
     * @param App\Section $section
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, Section $section)
    {
        $adsInSection = $section->ads()->latest()->get();
        $featured = $section->ads()->whereFeatured(true)->get();

        return view('section', compact('adsInSection', 'section', 'featured'));
    }
}
