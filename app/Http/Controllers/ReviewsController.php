<?php

namespace App\Http\Controllers;

use App\Repositories\MiscRepository;
use App\Repositories\ReviewsRepository;
use App\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function __construct(ReviewsRepository $reviewsRepository)
    {
        $this->reviewsRepository = $reviewsRepository;
    }

    public function reviews()
    {
        return $this->reviewsRepository->getReviews();
    }

    public function add_review($tekst, $author, $stars)
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
        $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);

        $country_code = $xml->geoplugin_countryCode;

        $this->reviewsRepository->insert_review($tekst, $author, $stars, $country_code);
        return $this->reviewsRepository->getReview($author);
    }

    public function sum_review()
    {
        Return [round(Review::all()->average('stars'),2), Review::all()->count()];
    }


}
