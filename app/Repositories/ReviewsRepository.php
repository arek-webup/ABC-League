<?php


namespace App\Repositories;


use App\Review;
use Carbon\Carbon;

class ReviewsRepository
{

    public function getReviews()
    {
        return Review::where('cookie',NULL)->get();
    }

    public function getReview($author)
    {
        return Review::where('author', $author)->get();
    }

    public function insert_review($tekst, $author, $stars, $country_code, $cookie)
    {
        Review::insert(
            ['tekst' => $tekst, 'author' => $author, 'stars' => $stars, 'country_code' => $country_code, 'cookie' => $cookie, 'flag' => "https://www.countryflags.io/".strtolower($country_code)."/flat/64.png", "created_at" =>  Carbon::now(), # new \Datetime()
                "updated_at" => Carbon::now() ]);
    }
}
