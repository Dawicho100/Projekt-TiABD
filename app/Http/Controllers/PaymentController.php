<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
class PaymentController extends Controller
{
    public function checkout()
    {
        return view('checkout');
    }

    public function session()
    {
        Stripe::setApiKey('sk_test_51OHT6eIcXC9mi8vystOvPutjXugM8Qwmgvbv09sST5JMufm5xb7NWp19eg2THnzI0Ocubrlpfc0vpVYdYNNy7RMr00C0i85xhk');
        $totalPrice = $_COOKIE['totalPrice'];

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'PLN',
                        'product_data' => [
                            'name' => 'Kwota do zapłaty',
                        ],
                        'unit_amount'  => $totalPrice*100,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url'  => route('products.index2'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {

        return redirect()->route('place-order');    }
}
