<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $userAds = Ad::where('user_id', '=', auth()->id())->get();

        return view('users.index', compact('userAds'));
    }
}
