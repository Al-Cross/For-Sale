<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'image' => ['required', 'image', 'dimensions:max_width=200,max_height=200']
        ]);

        $user->update([
            'avatar' => $request->file('image')->store('logos', 'public')
        ]);

        return response([], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Storage::disk('public')->delete($user->avatar);

        $user->avatar = 'users/default.png';
        $user->save();

        return response([], 204);
    }
}
