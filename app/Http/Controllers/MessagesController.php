<?php

namespace App\Http\Controllers;

use App\Sent;
use App\User;
use App\Inbox;
use App\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', auth()->id())->first();

        $inbox = $user->inbox()->with('message')->latest()->get();
        $sent = $user->sentMessages()->with('message')->latest()->get();
        $archived = $user->archivedMessages()->with('message')->latest()->get();

        return view('users.messages', compact('inbox', 'sent', 'archived'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parentMessage = null;

        $validatedData = $request->validate([
            'parent_message_id' => 'nullable',
            'ad_id' => 'numeric',
            'recipient_id' => ['required', 'numeric'],
            'subject' => ['required', 'min:2'],
            'body' => 'required'
        ]);

        if ($request->has('parent_message_id')) {
            $parentMessage = $request->parent_message_id;
        }

        $message = Message::create([
            'creator_id' => auth()->id(),
            'ad_id' => $validatedData['ad_id'],
            'recipient_id' => $validatedData['recipient_id'],
            'parent_message_id' => $parentMessage,
            'subject' => $validatedData['subject'],
            'body' => $validatedData['body']
        ]);

        $message->distribute($request->user()->id, $validatedData['recipient_id']);

        return back()->with('flash', 'Message successfully sent!');
    }

    /**
     * Remove the specified resource from inbox.
     *
     * @param int  $id The ID of App\Message
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyReceived($id)
    {
        $message = Inbox::findOrFail($id);

        $message->delete();

        return back()->with('flash', 'Message successfully removed!');
    }

    /**
     * Remove the specified resource from sent.
     *
     * @param int  $id The ID of App\Message
     *
     * @return \Illuminate\Http\Response
     */
    public function destroySent($id)
    {
        $message = Sent::findOrFail($id);

        $message->delete();

        return back()->with('flash', 'Message successfully removed!');
    }
}
