<?php


namespace App\Gateway;
use App\Repositories\MiscRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Omnipay\Omnipay;
use App\Order;
class PayPalGateway
{

    public $gateway;
    public $description;
    /**
     * @var MiscRepository
     */
    private $mR;

    public function __construct(PaymentGateway $pG, MiscRepository $mR)
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->mR = $mR;
        $this->gateway->setClientId('AfoLskmRTLs0d72eLUWz5cnwTzAFq7RPzrOo3-8mwX7phiEdB6dY7b-ZY0LnHACyi4-a_0LeBDSY7EIH');
        $this->gateway->setSecret(env('EPop364EX06ezxjiEoJjr0l1k6JQWhp115lZuenF6zLPttSEi8x0zNSSOkjlLfBJqfCioH4lniwot8t_'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live

    }

    public function charge(PaymentGateway $pG)
    {

            try {
                $response = $this->gateway->purchase(array(
                    'amount' => $pG->getPrice() * $pG->getQuantity(),
                    'currency' => $pG->getCurrency(),
                    'description' => $pG->getDescription(),
                    'returnUrl' => url('paymentsuccess'),
                    'cancelUrl' => url('paymenterror'),
                ))->send();

                if ($response->isRedirect()) {
//                    return $response->redirect(); // this will automatically forward the customer
                    return $response->getRedirectUrl();

                } else {
                    // not successful
                    return $response->getMessage();
                }
            } catch(Exception $e) {
                return $e->getMessage();
            }
    }

    public function payment_success(Request $request, $pG)
    {
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful())
            {
                // The customer has successfully paid.
                $arr_body = $response->getData();


                // Insert transaction data into the database
                $isPaymentExist = Order::where('order_id', $arr_body['id'])->first();

                if(!$isPaymentExist)
                {
                    $payment = new Order;
                    $payment->order_id = $arr_body['id'];
//                    $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                    $payment->email = $arr_body['payer']['payer_info']['email'];
                    $payment->price = $arr_body['transactions'][0]['amount']['total'];
                    $payment->currency = $arr_body['transactions'][0]['amount']['currency'];
                    $payment->status = $arr_body['state'];
                    $payment->countrycode = $arr_body['payer']['payer_info']['country_code'];
                    $payment->payment = 'PayPal';
                    $payment->quantity = '1';
                    $payment->description = 'Basic';
                    $payment->PLN = $this->mR->convertToPLN($arr_body['transactions'][0]['amount']['total'], $arr_body['transactions'][0]['amount']['currency'], 'PLN' );
                    $payment->firstname = $arr_body['payer']['payer_info']['first_name'];
                    $payment->lastname = $arr_body['payer']['payer_info']['last_name'];
                    $payment->save();

                    $url = 'http://cokolwiek.webup-dev.pl/?paymentId='.$arr_body['id'].'';
                    return redirect()->to($url)->send();
                }
                $url = 'http://cokolwiek.webup-dev.pl/?paymentId='.$arr_body['id'].'';
                return redirect()->to($url)->send();
//                return "Payment is successful. Your transaction id is: ". $arr_body['id'];

            } else {
                return $response->getMessage();
            }
        } else {
            return 'Transaction is declined';
        }
    }

    public function payment_error()
    {
        return 'User is canceled the payment.';
    }

}
