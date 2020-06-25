<?php


namespace App\Repositories;


use App\Review;

class ReviewsRepository
{

    public function getReviews()
    {
        return Review::all();
    }

    public function insert_review($tekst, $author, $stars)
    {
        Review::insert(
            ['tekst' => $tekst, 'author' => $author, 'stars' => $stars]);
    }
}
