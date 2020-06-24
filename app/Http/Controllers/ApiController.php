<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Controllers\Auth\VerificationController;
use App\Misc;
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


class ApiController extends Controller
{
    public function __construct(ReviewsRepository $reviewsRepository, AccountsRepository $aR, MiscRepository $mR, RegionsRepository $rR, PaymentGateway $paymentGateway, PayPalGateway $payPalGateway, StripeGateway $stripeGateway)
    {
        $this->aR = $aR;
        $this->mR = $mR;
        $this->rR = $rR;
        $this->reviewsRepository = $reviewsRepository;
        $this->paymentGateway = $paymentGateway;
        $this->paypalGateway = $payPalGateway;
        $this->stripeGateway = $stripeGateway;
    }

    public function accounts()
    {
        return response()->json($this->aR->getAllAccounts());
    }

    public function acc($id)
    {
        return $this->aR->getAccount($id);
    }

    public function accfromregion($id)
    {
        return $this->aR->getAvailableAccount($id);
    }

    public function available_acc()
    {
        return $this->aR->getAvailableAccounts();
    }

    public function available_accfromregion($id)
    {
        return $this->aR->getAvailableAccount($id);
    }



    public function reviews()
    {
        return $this->reviewsRepository->getReviews();
    }



    public function regions()
    {
        return $this->rR->getAllRegions();
    }

    public function getregion($id)
    {
        return $this->rR->getRegion($id);
    }

    public function available_regions()
    {
        return $this->rR->getAvailableRegions();
    }




    public function covert($price, $curr, $curr_sec)
    {
        return $this->mR->convertToPLN($price, $curr, $curr_sec);
    }

    public function getCountryCode()
    {
        return $this->mR->getCountryCode();
    }

}
