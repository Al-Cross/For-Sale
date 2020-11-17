<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.balance_options');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $amount = $request->validate([
            'value' => ['required', 'numeric']
        ]);

        $intent = $this->increaseBalance($amount['value'], auth()->user());

        $toPay = number_format($amount['value'] / 100, 2);

        return view('users.add_money', compact('intent', 'toPay'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = $request['result']['paymentIntent']['status'];
        $amount = $request['result']['paymentIntent']['amount'];

        if ($status === 'succeeded') {
            if (! auth()->user()->balance()->exists()) {
                auth()->user()->balance()->create(['amount' => $amount]);
            } else {
                $this->update($amount);
            }
        }
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
     * @param int  $amount
     */
    public function update($amount)
    {
        $currentBalance = auth()->user()->balance->amount;
        $newAmount = $currentBalance + $amount;
        auth()->user()->balance()->update(['amount' => $newAmount]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Add to the user's account.
     * @param  int $amount
     * @param  App\User $user
     * @return Stripe\PaymentIntent
     */
    public function increaseBalance($amount, $user)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
          'amount' => $amount,
          'currency' => 'eur',
          'metadata' => ['user_id' => $user->id],
        ]);

        return $intent;
    }
}
