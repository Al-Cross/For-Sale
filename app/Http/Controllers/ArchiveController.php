<?php

namespace App\Http\Controllers;

use App\Archive;
use App\Message;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function store(Message $message)
    {
        $message->archive(auth()->id());

        return back()->with('flash', 'The selected message has been archived.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id App\Message Id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Archive::findOrFail($id);

        $message->delete();

        return back()->with('flash', 'Message successfully removed!');
    }
}
