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

    public function __construct(MiscRepository $mR, VatService $vatService, PaymentGateway $pG, PayPalGateway $ppG)
    {
        $this->ppG = $ppG;
        $this->pG = $pG;
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

    public function koszyk(Request $request)
    {
        $data = $request->all();
//        $data = json_decode('[{"currency":"PLN","region_id":1,"name":"Premium","description":"<p>Level 30 Account.</p><p>60 000+ Blue Essence.</p><p>Unranked League All Seasons.</p><p>Fresh MMR.</p><p>Unverified e-mail.</p><p>Ordinary nickname, no bans or reports.</p><p>30 days botting-ban warranty.</p><p>Premium support.</p><p>Instant delivery.</p>","price_usd":"14.99","small":10.99,"medium":9.99,"large":8.99,"created_at":null,"updated_at":"2020-08-09T09:29:33.000000Z","slug":"EUNE smurf 50k+","factory":0,"count":53,"selQuantity":8},{"currency":"PLN","region_id":1,"name":"Standard","description":"<p>Level 30 Account.</p><p>50 000+ Blue Essence.</p><p>Unranked League All Seasons.</p><p>Fresh MMR.</p><p>Unverified e-mail.</p><p>Ordinary nickname, no bans or reports.</p><p>30 days botting-ban warranty.</p><p>Premium support.</p><p>Instant delivery.</p>","price_usd":"9.99","small":10.99,"medium":9.99,"large":8.99,"created_at":null,"updated_at":"2020-08-09T09:19:39.000000Z","slug":"EUW smurf 40k+","factory":0,"count":3,"selQuantity":2}]');
        foreach($data as $d)
        {
            $totalPrice[] = $d->price;
            $totalQuantity[] = $d->selQuantity;
            $totalName[] = $d->name;
            $totalRegion[] = $d->region_id;
        }
        dd($data);
        $this->pG->setEmail($request->email);
        $this->pG->setCurrency($request->currency);
        $this->pG->setPrice(array_sum($totalPrice));
        $this->pG->setQuantity(array_sum($totalQuantity));
        $this->pG->setDescription(json_encode($totalName));
        $this->pG->setRegion($totalRegion);
        return response()->json($this->ppG->charge($this->pG));

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
