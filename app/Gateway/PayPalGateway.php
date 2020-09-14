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
//        $this->gateway->setClientId('AbVK7Y_xycPRzS3YdrT7SURPMk2BudjiW9TClsTlN2W6PMknIu1bGgsqIc5WpPE09ouNq6Cwz7rRPYOt');
//        $this->gateway->setSecret('EP5S0goyINhyoRXTbs5WWDYVzP0_XmM6gC-RA4TZTIS9xFkY8RzJTxKVChdIO8mLDLzI4n06WFsn_c0O');
        $this->gateway->setClientId('AfqwvYCHb279PB7AbDWaiBsUiaXeSYsszykYDJyV71yYDFDcRNeXxQawqaV_kaUcKDS0pjngmJ_cVokH');
        $this->gateway->setSecret('EBevwsbenI3QOiFiIyAoTmaJNgXBeTXJr160Wqg-wGXVbl6dtOfaz61YxVuC2SSfP0Uf2xtUUi80RtmA');
        //$this->gateway->setUsername('officeabcleague@gmail.com');
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

                $regionid = Region::where('name',$payment->region_id)->get()[0]->id;

                return $this->aR->checkAvaliblity($regionid,$payment->description,$payment->quantity);

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
