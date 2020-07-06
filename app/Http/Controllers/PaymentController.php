<?php

namespace App\Http\Controllers;
use Omnipay\Omnipay;
use App\Gateway\PaymentGateway;
use App\Gateway\PayPalGateway;
use App\Gateway\StripeGateway;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

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
         return $this->ppG->charge($this->pG)->getRedirectUrl();
    }
    public function pay_stripe(Request $request)
    {
        $this->pG->setEmail($request->email);
        $this->pG->setCurrency($request->currency);
        $this->pG->setPrice($request->price);
        $this->pG->setQuantity($request->quantity);
        $this->pG->setDescription($request->description);
        $this->sG->showForm($this->pG);
    }

    public function payment_success(Request $request)
    {
        $this->ppG->payment_success($request, $this->pG->getDescription());
    }

    public function payment_error()
    {
        return 'Payment was canceled.';
    }
}
