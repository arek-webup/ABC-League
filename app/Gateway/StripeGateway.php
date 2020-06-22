<?php


namespace App\Gateway;


use App\Account;
use App\Code;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;

class StripeGateway
{

    public function stripePost(Request $request, PaymentGateway $pG)
    {

        Stripe::setApiKey('sk_live_TqQ81eH9fDYIJdCq9y3BLEKu00NSWw5FdP');
        try {
            Charge::create(array(
                "amount" => $pG->getPrice() * 100,
                "currency" => $pG->getCurrency(),
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => $pG->getDescription()." by ".$pG->getEmail()
            ));
            Session::flash('success-message', 'Payment done successfully !');



            $acc = Account::where('name', $pG->getDescription() )->first();
            $code = Code::where('account_id', $acc->id)->get()->take($pG->getQuantity());

            $order = Order::where('order_id', $order_id)->first();

            $order->status = 'Zaplacono';
            $order->payment = 'Stripe';
            $order->name = $lastsur;
            $order->code = $code;
            $order->update();

            Mail::send( 'mail.index',['code' => $code, 'email' => $email, 'name' => $name, 'order_id' => $order_id] ,function($message) use ($email) {
                $message->from ( 'admin@abc-league.com', 'ABC League' );
                $message->to($email, 'Tak')->subject('Thank you for purchase account(s)!');
            });

            $code_del = Code::where('account_id', $acc[0]->id)->take($quantity)->delete();

            return view('Front.success', ['code' => $code   ]);
        } catch (\Exception $e) {
            Session::flash('fail-message', "Error! Please Try again.");
            return dd($e);
        }
    }

}
