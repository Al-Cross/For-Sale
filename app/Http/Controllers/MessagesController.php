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

        $inbox = $user->inbox()->latest()->get();
        $sent = $user->sentMessages()->latest()->get();
        $archived = $user->archivedMessages()->latest()->get();

        return view('users.messages', compact('inbox', 'sent', 'archived'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $message->sent()->create(['user_id' => $request->user()->id]);
        $message->inbox()->create(['user_id' => $validatedData['recipient_id']]);

        return back()->with('flash', 'Message successfully sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * Remove the specified resource from inbox.
     *
     * @param  int  $id App\Message Id
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
     * @param  int  $id App\Message Id
     * @return \Illuminate\Http\Response
     */
    public function destroySent($id)
    {
        $message = Sent::findOrFail($id);

        $message->delete();

        return back()->with('flash', 'Message successfully removed!');
    }
}
