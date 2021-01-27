<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Get all new notifications of the user.
     *
     * @return Illuminate\Eloquent\Collection
     */
    public function show()
    {
        return Auth::user()->unreadNotifications;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        $value = $request->validate([
            'newMessage' => 'boolean',
            'loweredPrice' => 'boolean'
        ]);

        $request->user()->notificationSettings()->update([
            'new_message' => $value['newMessage'],
            'lowered_price' => $value['loweredPrice']
        ]);

        return response(['Your preferences have been updated!'], 201);
    }
    /**
     * Mark a notification as read.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $user->notifications()->findOrFail($id)->markAsRead();
    }

    public function destroyAll()
    {
        $user = Auth::user();

        $user->notifications->map(function($notification) {
            $notification->markAsRead();
        });
    }
}
