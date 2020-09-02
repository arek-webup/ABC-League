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
use App\Services\VatService;
use DvK\Laravel\Vat\Facades\Rates;
use DvK\Laravel\Vat\Facades\Validator;
use DvK\Laravel\Vat\Facades\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function __construct(MiscRepository $mR, VatService $vatService)
    {
        $this->mR = $mR;
        $this->vatService = $vatService;
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

    public function checkVat($countryCode, $vies)
    {
        return $this->vatService->viesCheckVAT($countryCode, $vies);
    }

    public function checkVatRate($countryCode)
    {
        return $this->vatService->getVatRate($countryCode);
    }




}
