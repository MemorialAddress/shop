<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function checkout()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'line_items' => [[
                'price' => 'price_xxxxxxx',
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/success'),
        ]);

        return redirect()->away($session->url);
    }
}