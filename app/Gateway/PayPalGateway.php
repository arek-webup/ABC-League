<?php


namespace App\Gateway;
use App\Account;
use App\Code;
use App\Region;
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
        $this->gateway->setClientId('AepWl7aJbpJ53rL1rNW_yKzhxrIcVbeVeF4xHbnctWMTuqlXJWQN5sHuIrB-_fmIzTmipErMlcpD_NIi');
        $this->gateway->setSecret(env('EMuXz49NpoWuSH6j0-a82uUHUKdpTIDOklMmUKDN5kmT5N_GoxX5knYpi8QICLDIx2cxLiEHESWlHNML'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live

    }

    public function charge(PaymentGateway $pG)
    {


            try {
                $response = $this->gateway->purchase(array(
                    'amount' => $pG->getPrice() * 1,
                    'currency' => $pG->getCurrency(),
                    'description' => $pG->getDescription(),
                    'returnUrl' => url('paymentsuccess'),
                    'cancelUrl' => url('paymenterror'),
                ))->send();
                $payment = new Order;
                $payment->order_id = $response->getData()['id'];
                $payment->region_id = $pG->getRegion();
                $payment->description = $pG->getDescription();
                $payment->quantity = $pG->getQuantity();
                $payment->save();
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
            return dd($response);
            if ($response->isSuccessful())
            {
                return dd($request);
                // The customer has successfully paid.
                $arr_body = $response->getData();


                // Insert transaction data into the database
                $lol = Order::where('order_id', $arr_body['id'])->first();




                    $payment = Order::where('order_id',$arr_body['id'])->first();

                    $regionid = Region::where('name',$payment->region_id)->get()[0]->id;
                    $acc = Account::where('region_id',$regionid)->where("name",$payment->description)->count();
                    $account_id = Account::where('region_id',$regionid)->where("name",$payment->description)->get()[0]->id;
                    $code = Code::where('account_id', $account_id)->get()->take($payment->quantity);

                    $payment->email = $arr_body['payer']['payer_info']['email'];
                    $payment->price = $arr_body['transactions'][0]['amount']['total'];
                    $payment->currency = $arr_body['transactions'][0]['amount']['currency'];
                    $payment->status = $arr_body['state'];
                    $payment->countrycode = $arr_body['payer']['payer_info']['country_code'];
                    $payment->payment = 'PayPal';
                    $payment->quantity = '1';

                    $payment->code = $code;
                    $payment->PLN = $this->mR->convertToPLN($arr_body['transactions'][0]['amount']['total'], $arr_body['transactions'][0]['amount']['currency'], 'PLN' );
                    $payment->firstname = $arr_body['payer']['payer_info']['first_name'];
                    $payment->lastname = $arr_body['payer']['payer_info']['last_name'];
                    $payment->save();

                    Code::where('account_id', $account_id)->take($payment->quantity)->delete();


                $url = 'https://accounts4life.com/payment/'.$arr_body['id'].'';
                return redirect()->to($url)->send();
//                return "Payment is successful. Your transaction id is: ". $arr_body['id'];

            } else {
                return "not success";
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
