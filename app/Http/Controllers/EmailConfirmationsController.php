<?php

namespace App\Http\Controllers;

use App\Mail\DeletionEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailConfirmationsController extends Controller
{
    /**
     * Display a confirmation message.
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.email_sent');
    }

    /**
     * Send a confirmation email for profile deletion.
     */
    public function destroy()
    {
        Mail::to(auth()->user()->email)->send(new DeletionEmail(auth()->id()));
    }
}
