<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddMoneyToAccountTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function authenticated_users_can_visit_the_page_to_add_money()
    {
        $this->signIn();

        $this->get('/myaccount/wallet/load-account')
            ->assertSee('Choose the sum you would like to load')
            ->assertStatus(200);
    }
    /**
     * @test
     */
    public function authenticated_users_can_add_to_their_balance()
    {
    	$this->signIn();

    	$response = $this->post(route('process_payment'), [
    		'value' => '2000'
    	]);

    	$this->assertEquals($response['intent']['amount'], 2000);

    	// Mock the response from Stripe API
    	$status = ['result' => [
    		'paymentIntent' => [
    			'status' => 'succeeded',
    			'amount' => $response['intent']['amount']
    		]
    	]];

    	$this->postJson(route('add_to_balance'), $status);

    	$this->assertDatabaseHas('balances', ['amount' => '2000']);
    }
}
