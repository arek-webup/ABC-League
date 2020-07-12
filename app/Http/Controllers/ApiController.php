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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use http\Client\Response;
use App\Repositories\AccountsRepository;
use App\Repositories\RegionsRepository;
use App\Repositories\MiscRepository;
use App\Gateway\PaymentGateway;
use App\Gateway\PayPalGateway;
use App\Gateway\StripeGateway;
use PHPUnit\Framework\Constraint\IsEmpty;


class ApiController extends Controller
{

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
        return response()->json($this->mR->getCurrency());
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



}
