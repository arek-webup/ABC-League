<?php

namespace App\Http\Controllers;
use App\Order;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;
use App\Gateway\PaymentGateway;
use App\Gateway\PayPalGateway;

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
        $this->pG->setCurrency($request->currency);
        $this->pG->setPrice($request->price);
        $this->pG->setQuantity($request->quantity);
        $this->pG->setDescription($request->description);
        $this->pG->setRegion($request->region);
        return response()->json($this->ppG->charge($this->pG));
    }

    public function checkout_paypal(Request $request)
    {
        return response()->json('success paypal');
    }

    public function checkout_stripe(Request $request)
    {
        return response()->json('succcess stripe');

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
