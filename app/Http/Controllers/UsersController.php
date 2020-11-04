<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAds = Ad::where('user_id', '=', auth()->id())->get();

        return view('users.index', compact('userAds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = auth()->user();
        $user->load('notificationSettings');

        return view('users.settings', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id)]
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return view('users.profile_deleted');
    }

    /**
     * Update the user's password in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        if (Hash::check($request->old_pass, $user->getAuthPassword())) {
            $request->validate([
                'password' => ['required', 'string', 'min:8']
            ]);

            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();
        } else {
            return response()
                ->json(['errors' =>
                    ['old_pass' => 'The password does not match that on file.']
                ], 422);
        }
    }
}
