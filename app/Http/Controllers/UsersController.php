<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UsersController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve the user's ads and get the count of the messages
        // they received for each ad
        $userAds = Ad::where('user_id', '=', auth()->id())
            ->latest()
            ->withCount(['messages' => function (Builder $query) {
                $query->where('recipient_id', '=', auth()->id());
            }])
            ->get();
        if (! auth()->user()->balance()->exists()) {
            auth()->user()->balance()->create(['amount' => 0]);
        }
        $balance = auth()->user()->balance->getBalance();
        $promotionPrice = number_format(config('for-sale.prices.featured') / 100, 2);
        $extensionPrice = number_format(config('for-sale.prices.ad_extension') / 100, 2);

        return view(
            'users.index',
            compact('userAds', 'balance', 'promotionPrice', 'extensionPrice')
        );
    }

    /**
     * Fetch all ads of the given user.
     *
     * @param App\User $user The creator of the ads
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $userAds = Ad::where('user_id', $user->id)
            ->excludeArchived()
            ->latest()
            ->get();

        return view('users.ads', compact('userAds', 'user'));
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
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id)],
            'address' => ['string', 'nullable'],
            'phone' => ['string', 'nullable'],
            'about' => ['string', 'nullable']
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'about' => $validated['about']
        ]);

        return response(['Profile was successfully updated!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param App\User $user
     *
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
     * @param Request $request
     *
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
