<?php

namespace App\Http\Controllers;
use App\Order;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;
use App\Gateway\PaymentGateway;
use App\Gateway\PayPalGateway;
use App\Gateway\StripeGateway;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{

    /**
     * @var StripeGateway
     */
    private $sG;

    public function __construct(PaymentGateway $pG, StripeGateway $sG, PayPalGateway $ppG)
    {
        $this->pG = $pG;
        $this->sG = $sG;
        $this->ppG = $ppG;
    }

    public function pay_paypal(Request $request)
    {
        $this->pG->setEmail($request->email);
        $this->pG->setCurrency($request->currency);
        $this->pG->setPrice($request->price);
        $this->pG->setQuantity($request->quantity);
        $this->pG->setDescription($request->description);
         return response()->json($this->ppG->charge($this->pG));
    }
    public function pay_stripe(Request $request)
    {

        Stripe::setApiKey('sk_live_TqQ81eH9fDYIJdCq9y3BLEKu00NSWw5FdP');
        try {
            Charge::create(array(
                "amount" => 1,
                "currency" => $request->currency,
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => $request->name." by ".$request->email
            ));
            Session::flash('success-message', 'Payment done successfully !');


//
//            $acc = Account::where('name', $request->name )->get();
//            $code = Code::where('account_id', $acc[0]->id)->get()->take($quantity);
//
//            $order = Order::where('order_id', $order_id)->first();
//
//            $order->status = 'Zaplacono';
//            $order->payment = 'Stripe';
//            $order->name = $lastsur;
//            $order->code = $code;
//            $order->update();
//
//            Mail::send( 'mail.index',['code' => $code, 'email' => $email, 'name' => $name, 'order_id' => $order_id] ,function($message) use ($email) {
//                $message->from ( 'admin@abc-league.com', 'ABC League' );
//                $message->to($email, 'Tak')->subject('Thank you for purchase account(s)!');
//            });
//
//            $code_del = Code::where('account_id', $acc[0]->id)->take($quantity)->delete();

            return 'success';
        } catch (\Exception $e) {
            Session::flash('fail-message', "Error! Please Try again.");
            return $e;
        }
    }

    public function payment_success(Request $request)
    {
        $this->ppG->payment_success($request, $this->pG->getDescription());
    }

    public function payment_error()
    {
        return 'Payment was canceled.';
    }

    public function verify($orderid)
    {
        return response()->json(Order::where('order_id', $orderid)->first());
    }
}
