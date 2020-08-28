<?php

namespace App\Http\Controllers;

use App\Account;
use App\Code;
use App\Coupon;
use App\Http\Controllers\Auth\VerificationController;
use App\Misc;
use App\Order;
use App\Region;

use App\Repositories\ReviewsRepository;
use App\Review;
use DvK\Laravel\Vat\Facades\Rates;
use DvK\Laravel\Vat\Facades\Validator;
use DvK\Laravel\Vat\Facades\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use http\Client\Response;
use App\Repositories\AccountsRepository;
use App\Repositories\RegionsRepository;
use App\Repositories\MiscRepository;
use App\Gateway\PaymentGateway;
use App\Gateway\PayPalGateway;
use App\Gateway\StripeGateway;
use Omnipay\Omnipay;
use PHPUnit\Framework\Constraint\IsEmpty;



class ApiController extends Controller
{

    /**
     * @var \Omnipay\Common\GatewayInterface
     */
    private $gateway;

    public function __construct(MiscRepository $mR)
    {
        $this->mR = $mR;
    }

    public function coupons()
    {
        $coupon = Coupon::all();
        return response()->json($coupon);
    }

    public function covert($price, $curr, $curr_sec)
    {
        return $this->mR->convertToPLN($price, $curr, $curr_sec);
    }

    public function getCurrency()
    {
        return $this->mR->getCurrency();
    }

    public function getCountryCode()
    {
        return response()->json($this->mR->getCountry());
    }

    public function charge()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');

        $this->gateway->setClientId('AfoLskmRTLs0d72eLUWz5cnwTzAFq7RPzrOo3-8mwX7phiEdB6dY7b-ZY0LnHACyi4-a_0LeBDSY7EIH');
        $this->gateway->setSecret(env('EPop364EX06ezxjiEoJjr0l1k6JQWhp115lZuenF6zLPttSEi8x0zNSSOkjlLfBJqfCioH4lniwot8t_'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live
        try {
            $response = $this->gateway->purchase(array(
                'amount' => 1*1,
                'currency' => "PLN",
                'description' => "opis",
                'returnUrl' => url('paymentsuccess'),
                'cancelUrl' => url('paymenterror'),
            ))->send();

            if ($response->isRedirect()) {
//                    return $response->redirect(); // this will automatically forward the customer
                return dd($response->getData());

            } else {
                // not successful
                return $response->getMessage();
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function getIP()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return response()->json($ip);
    }

    public function test($ip)
    {
        $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);
        return [$xml->geoplugin_currencyCode, $xml->geoplugin_continentCode];
    }




    function viesCheckVAT($countryCode, $vatNumber, $timeout = 30) {
        $response = array ();
        $pattern = '/<(%s).*?>([\s\S]*)<\/\1/';
        $keys = array (
            'countryCode',
            'vatNumber',
            'requestDate',
            'valid',
            'name',
            'address',
            'vat_rate'
        );

        $content = "<s11:Envelope xmlns:s11='http://schemas.xmlsoap.org/soap/envelope/'>
  <s11:Body>
    <tns1:checkVat xmlns:tns1='urn:ec.europa.eu:taxud:vies:services:checkVat:types'>
      <tns1:countryCode>%s</tns1:countryCode>
      <tns1:vatNumber>%s</tns1:vatNumber>
    </tns1:checkVat>
  </s11:Body>
</s11:Envelope>";
        $rates =

        $opts = array (
            'http' => array (
                'method' => 'POST',
                'header' => "Content-Type: text/xml; charset=utf-8; SOAPAction: checkVatService",
                'content' => sprintf ( $content, $countryCode, $vatNumber ),
                'timeout' => $timeout
            )
        );
        //return dd($rates);
        $ctx = stream_context_create ( $opts );
        $result = file_get_contents ( 'http://ec.europa.eu/taxation_customs/vies/services/checkVatService', false, $ctx );

        if (preg_match ( sprintf ( $pattern, 'checkVatResponse' ), $result, $matches )) {
            foreach ( $keys as $key )
                preg_match ( sprintf ( $pattern, $key ), $matches [2], $value ) && $response [$key] = $value [2];
        }
        $url = "http://api.vatlookup.eu/rates/".$countryCode."/";

        $vat_rate = json_decode(file_get_contents($url), true);
        $response['vat_rate'] = $vat_rate['rates'][2]['rates'][0];
        return $response;


    }



}
