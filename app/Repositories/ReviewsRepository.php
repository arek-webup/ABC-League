<?php


namespace App\Repositories;


use App\Review;

class ReviewsRepository
{

    public function getReviews()
    {
        return Review::all();
    }
}
