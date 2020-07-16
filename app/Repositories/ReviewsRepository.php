<?php


namespace App\Repositories;


use App\Review;
use Carbon\Carbon;

class ReviewsRepository
{

    public function getReviews()
    {
        return Review::all();
    }

    public function getReview($author)
    {
        return Review::where('author', $author)->get();
    }

    public function insert_review($tekst, $author, $stars)
    {
        Review::insert(
            ['tekst' => $tekst, 'author' => $author, 'stars' => $stars, "created_at" =>  Carbon::now(), # new \Datetime()
                "updated_at" => Carbon::now() ]);
    }
}
