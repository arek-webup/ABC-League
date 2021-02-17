<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function stripe()
    {
        \Stripe\Stripe::setApiKey('sk_test_FuGZMSTZmQurSsANgaKvQZU3005FjmoFdu');



        $session = \Stripe\BillingPortal\Session::create([
            'customer' => '123',
            'return_url' => 'https://example.com/account',
        ]);


        header("Location: " . $session->url);
        exit();
    }
}
